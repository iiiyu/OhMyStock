<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Company;
use App\Models\Series;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class FetchHistoricalStockData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:history {symbol} {--interval=daily}';

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

        // 2. 调用API获取数据

        $response = Http::get('https://www.alphavantage.co/query', [
            'function' => 'TIME_SERIES_DAILY_ADJUSTED',
            'symbol' => $symbol,
            'outputsize' => 'full',
            'apikey' => 'GJUDYKDQKC0OFP5P',
        ]);

        $tmpArray = json_decode($response->body(), true);

        if (!array_key_exists('Meta Data', $tmpArray)) {
            echo $tmpArray['Error Message'];
            return 0;
        }

        $data = $tmpArray['Time Series (Daily)'];

        // 3. 写入数据库

        // $table->unsignedBigInteger('company_id');
        // $table->date('closed_at')->comment('收盘时间');
        // $table->enum('interval', ['Daily', 'Weekly', 'Monthly'])->comment('记录时间颗粒度');
        // $table->decimal('open', 11, 4)->comment('开盘价格');
        // $table->decimal('high', 11, 4)->comment('最贵价格');
        // $table->decimal('low', 11, 4)->comment('最低价格');
        // $table->decimal('close', 11, 4)->comment('收盘价格');
        // $table->decimal('adjusted_close', 11, 4)->comment('复权后的收盘价');
        // $table->bigInteger('volume')->comment('交易量');
        // $table->decimal('dividend_amount', 11, 4)->comment('股息');
        // $table->decimal('split_coefficient', 8, 2)->comment('拆股');
        // $table->foreign('company_id')->references('id')->on('companies');

        $insertData = [];
        foreach ($data as $key => $value) {

            $insertData[] = [
                'company_id' => $company->id, 'closed_at' => $key, 'interval' => 'Daily',
                'open' => $value['1. open'], 'high' => $value['2. high'],
                'low' => $value['3. low'], 'close' => $value['4. close'],
                'adjusted_close' => $value['5. adjusted close'], 'volume' => $value['6. volume'],
                'dividend_amount' => $value['7. dividend amount'], 'split_coefficient' => $value['8. split coefficient']
            ];
        }

        $collection = collect($insertData);
        $chunks = $collection->chunk(100);

        try {
            DB::beginTransaction();

            foreach ($chunks->toArray() as $chunk) {
                Series::upsert(
                    $chunk,
                    ['company_id', 'closed_at', 'interval'],
                    ['open', 'high', 'low', 'close', 'adjusted_close', 'volume', 'dividend_amount', 'split_coefficient',]
                );
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }










        // dd($data);

        // dd($tmpArray);


        echo $this->argument('symbol');
        echo '\n';
        echo $this->option('interval');
        return 0;
    }
}
