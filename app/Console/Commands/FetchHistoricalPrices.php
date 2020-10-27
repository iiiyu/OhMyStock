<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Company;
use App\Models\HistoricalPrice;
use Illuminate\Support\Facades\DB;


class FetchHistoricalPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:iex:historical {symbol} {--range=2y}';

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


        // 2. 调用API获取数据

        $rangeName = $this->option('range');

        $token = env('IEXCLOUD_TOKEN');

        $base_url = 'https://cloud.iexapis.com/stable/stock/' . Str::lower($this->argument('symbol')) . '/chart/' . $rangeName . '?token=' . $token;

        $this->info('Fetch ' . $company->symbol);
        $response = Http::get($base_url);

        $tmpArray = json_decode($response->body(), true);
        $this->info('Fetch Done');
        if (is_null($tmpArray) || count($tmpArray) == 0) {
            $this->error('Error Message: ' . $company->symbol . ' no data');
            return 0;
        }

        // 写入数据库

        $insertData = [];
        foreach ($tmpArray as $item) {
            $insertData[] = [
                'company_id' => $company->id, 'closed_at' => $item['date'],
                'open' => $item['open'], 'high' => $item['high'],
                'low' => $item['low'], 'close' => $item['close'],
                'volume' => $item['volume'], 'u_volume' => $item['uVolume'],
                'u_open' => $item['uOpen'], 'u_high' => $item['uHigh'],
                'u_low' => $item['uLow'], 'u_close' => $item['uClose'],
                'change_over_time' => $item['changeOverTime'], 'change' => $item['change'],
                'change_percent' => $item['changePercent']
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
                        'open', 'high', 'low', 'close',  'volume',
                        'u_open', 'u_high', 'u_low', 'u_close',  'u_volume',
                        'change_over_time',  'change', 'change_percent',
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
