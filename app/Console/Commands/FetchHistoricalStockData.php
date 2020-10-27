<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Company;
use App\Models\HistoricalPrice;
use Illuminate\Support\Facades\DB;


class FetchHistoricalStockData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:alpha:historical {symbol} {--interval=daily}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Historical Stock Data  {symbol} --interval={daily, weekily, monthly}';

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

        $apikey = env('ALPHAVANTAGE_API_KEY');

        // 2. 调用API获取数据

        $response = Http::get('https://www.alphavantage.co/query', [
            'function' => 'TIME_SERIES_DAILY_ADJUSTED',
            'symbol' => $symbol,
            'outputsize' => 'full',
            'apikey' => $apikey,
        ]);

        $tmpArray = json_decode($response->body(), true);

        if (!array_key_exists('Meta Data', $tmpArray)) {
            $this->error('Error Message');
            dd($tmpArray);
            return 0;
        }

        $data = $tmpArray['Time Series (Daily)'];

        // 3. 写入数据库

        $insertData = [];
        foreach ($data as $key => $value) {

            $insertData[] = [
                'company_id' => $company->id, 'closed_at' => $key,
                'open' => $value['1. open'], 'high' => $value['2. high'],
                'low' => $value['3. low'], 'close' => $value['4. close'],
                'volume' => $value['6. volume'],
            ];
        }

        $collection = collect($insertData);
        $chunks = $collection->chunk(100);

        try {
            DB::beginTransaction();

            foreach ($chunks->toArray() as $chunk) {
                HistoricalPrice::upsert(
                    $chunk,
                    ['company_id', 'closed_at'],
                    ['open', 'high', 'low', 'close', 'volume']
                );
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        return 0;
    }
}
