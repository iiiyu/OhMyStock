<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Company;

use Illuminate\Support\Facades\DB;

class SyncSPXData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:spx:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync TradingView s&p 500 data';

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
        // 1. 调用API获取数据

        $response = Http::withHeaders([
            "Authority" => "scanner.tradingview.com",
            "Pragma" => "no-cache",
            "Cache-Control" => "no-cache",
            "Accept" => "text/plain, */*; q=0.01",
            "Content-Type" => "application/x-www-form-urlencoded; charset=UTF-8",
            "Origin" => "https://www.tradingview.com",
            "Sec-Fetch-Site" => "same-site",
            "Sec-Fetch-Mode" => "cors",
            "Sec-Fetch-Dest" => "empty",
            "Referer" => "https://www.tradingview.com/",
            "Accept-Language" => "en-US,en;q=0.9,zh-CN;q=0.8,zh;q=0.7",
            "Accept-Encoding" => "gzip"
        ])->post("https://scanner.tradingview.com/america/scan", [
            'range' => [
                0,
                600
            ],
            'filter' => [
                [
                    'operation' => 'nempty',
                    'left' => 'market_cap_basic'
                ]
            ],
            'options' => [
                'lang' => 'en'
            ],
            'symbols' => [
                'query' => [
                    'types' => []
                ],
                'tickers' => [],
                'groups' => [
                    [
                        'type' => 'index',
                        'values' => [
                            'SP:SPX'
                        ]
                    ]
                ]
            ],
            'columns' => [
                'logoid',
                'name',
                'close',
                'change',
                'change_abs',
                'Recommend.All',
                'volume',
                'market_cap_basic',
                'price_earnings_ttm',
                'earnings_per_share_basic_ttm',
                'number_of_employees',
                'sector',
                'description',
                'type',
                'subtype',
                'update_mode',
                'pricescale',
                'minmov',
                'fractional',
                'minmove2'
            ],
            'sort' => [
                'sortBy' => 'market_cap_basic',
                'sortOrder' => 'desc'
            ]
        ]);

        $tmpArray = json_decode($response->body(), true);

        if (!array_key_exists('totalCount', $tmpArray)) {
            $this->error('Error Message');
            dd($tmpArray);
            return 0;
        }

        $data = $tmpArray['data'];

        // 3. 写入数据库

        $insertData = [];
        foreach ($data as $value) {


            $stock_market = explode(':', $value['s'])[0];

            $insertData[] = [
                'symbol' => $value['d'][1], 'name' => $value['d'][12], 'stock_market' => $stock_market,
                'logo_id' => $value['d'][0], 'volume' => $value['d'][6],
                'market_cap_basic' => $value['d'][7], 'price_earnings_ttm' => $value['d'][8],
                'earnings_per_share_basic_ttm' => $value['d'][9], 'number_of_employees' => $value['d'][10],
                'sector' => $value['d'][11], 'is_spx' => true
            ];
        }

        $collection = collect($insertData);
        $chunks = $collection->chunk(20);

        try {
            DB::beginTransaction();

            foreach ($chunks->toArray() as $chunk) {
                Company::upsert(
                    $chunk,
                    ['symbol'],
                    ['name', 'stock_market', 'logo_id', 'volume', 'market_cap_basic', 'price_earnings_ttm', 'earnings_per_share_basic_ttm', 'number_of_employees', 'sector', 'is_spx']
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
