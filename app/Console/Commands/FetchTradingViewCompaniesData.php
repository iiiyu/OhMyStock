<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Utils\Log\Facades\FileLog as FileLog;

class FetchTradingViewCompaniesData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:tradingview:companies {type=spx}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch TradingView companies data  {type=spx ndx}';

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

        $type = $this->argument('type');

        if (!in_array($type, ['spx', 'ndx'])) {
            return 0;
        }

        $isSPX = false;

        $isNDX = false;

        if ('spx' === $type) {
            $isSPX = true;
        }

        if ('ndx' === $type) {
            $isNDX = true;
        }

        $range = 600;
        $indexTypeValue = 'SP:SPX';

        if ($isSPX) {
            $indexTypeValue = 'SP:SPX';
            $range = 600;
        }

        if ($isNDX) {
            $indexTypeValue = 'NASDAQ:NDX';
            $range = 150;
        }

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
                $range
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
                            $indexTypeValue
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

        // 2. 写入数据库
        $insertData = [];
        foreach ($data as $value) {

            $stock_market = explode(':', $value['s'])[0];
            $item = [
                'symbol' => $value['d'][1], 'name' => $value['d'][12], 'stock_market' => $stock_market,
                'logo_id' => $value['d'][0], 'volume' => $value['d'][6],
                'market_cap_basic' => $value['d'][7], 'price_earnings_ttm' => $value['d'][8],
                'earnings_per_share_basic_ttm' => $value['d'][9], 'number_of_employees' => $value['d'][10],
                'sector' => $value['d'][11]
            ];

            if ($isSPX) {
                $item['is_spx'] = true;
            }

            if ($isNDX) {
                $item['is_ndx'] = true;
            }

            $insertData[] = $item;
        }

        $collection = collect($insertData);
        $chunks = $collection->chunk(20);

        try {
            $canChangeValues = ['name', 'stock_market', 'logo_id', 'volume', 'market_cap_basic', 'price_earnings_ttm', 'earnings_per_share_basic_ttm', 'number_of_employees', 'sector'];

            DB::beginTransaction();
            if ($isSPX) {
                Company::query()->update(['is_spx' => false]);
                $canChangeValues[] = 'is_spx';
            }

            if ($isNDX) {
                Company::query()->update(['is_ndx' => false]);
                $canChangeValues[] = 'is_ndx';
            }

            foreach ($chunks->toArray() as $chunk) {
                Company::upsert(
                    $chunk,
                    ['symbol'],
                    $canChangeValues
                );
            }
            DB::commit();
            $message = 'Sync S&P 500 Done';

            if ($isSPX) {
                $message = 'Sync S&P 500 Done';
            }

            if ($isNDX) {
                $message = 'Sync NASDAQ 100 Done';
            }

            FileLog::company($message);
            Log::channel('discord')->info($message);
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        return 0;
    }
}
