<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Company;
use App\Models\HistoricalPrice;
use Illuminate\Support\Facades\DB;


class FetchYFinanceHistoricalPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:yf:historical {symbol} {--range=2y}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Historical Prices Data {symbol} --range={ max 5y 2y 1y ytd 6m 3m 1m 1mm 5d 5dm date dynamic }';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $symbol = Str::upper($this->argument('symbol'));

        // 1. 查询是否在数据库里面
        $company = Company::where('symbol', $symbol)->firstOrFail();
        $symbol = Str::of($symbol)->replace('.', '-');

        // 2. 调用API获取数据

        $rangeName = $this->option('range');

        $base_url = env('YF_URL') . '/api/stock' . '?symbol=' . $symbol . '&range=' . $rangeName;

        // $token = env('IEXCLOUD_TOKEN');

        // $base_url = 'https://cloud.iexapis.com/stable/stock/' . Str::lower($this->argument('symbol')) . '/chart/' . $rangeName . '?token=' . $token;

        $this->info('Fetch ' . $company->symbol);
        $response = Http::get($base_url);

        $tmpArray = json_decode($response->body(), true);
        $this->info('Fetch Done');
        if (is_null($tmpArray) || count($tmpArray) == 0) {
            $this->error('Error Message: ' . $company->symbol . ' no data');
            return 0;
        }

        // 写入数据库

        $o_pirces = $tmpArray['Open'];
        $h_pirces = $tmpArray['High'];
        $l_pirces = $tmpArray['Low'];
        $c_pirces = $tmpArray['Close'];
        $volumes = $tmpArray['Volume'];

        $insertData = [];
        foreach ($o_pirces as $key => $value) {
            $closed_at = date("Y-m-d", substr($key, 0, 10));
            $insertData[] = [
                'company_id' => $company->id, 'closed_at' => $closed_at,
                'open' => $value, 'high' => $h_pirces[$key],
                'low' => $l_pirces[$key], 'close' => $c_pirces[$key],
                'volume' => $volumes[$key]
            ];
        }


        $collection = collect($insertData);
        $chunks = $collection->chunk(50);

        try {
            DB::beginTransaction();
            $this->info('Begin Update Database.');
            foreach ($chunks->toArray() as $chunk) {
                HistoricalPrice::upsert(
                    $chunk,
                    ['company_id', 'closed_at'],
                    [
                        'open', 'high', 'low', 'close',  'volume'
                    ]
                );
            }
            DB::commit();
            $this->info($company->symbol . ' Update Database Done.');
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        return 0;
    }
}
