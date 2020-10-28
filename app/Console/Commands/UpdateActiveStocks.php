<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Models\Company;
use App\Models\HistoricalPrice;
use App\Models\ActiveStock;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use App\Utils\Log\Facades\FileLog as FileLog;

class UpdateActiveStocks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:active {symbol}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update active stocks';

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

        // 2. 查询数据&&计算数据

        // 2.1 VTI

        if (HistoricalPrice::where('company_id', $company->id)->count() < 300) {
            return 0;
        }

        $series = HistoricalPrice::where('company_id', $company->id)->orderBy('closed_at', 'desc')->limit(20)->get();
        $last_price = doubleval($series[0]['close']);
        $before_last_price = $series[1]['close'];
        $before_five_day_price = $series[4]['close'];
        $before_twenty_day_price = $series[19]['close'];
        $last_tradvol = $series[0]['volume'];
        $calculated_at = $series[0]['closed_at'];
        $one_day_change = ($last_price - $before_last_price) / $before_last_price;
        $five_day_change = ($last_price - $before_five_day_price) / $before_five_day_price;
        $twenty_day_change = ($last_price - $before_twenty_day_price) / $before_twenty_day_price;


        // VTI
        $vti_series = HistoricalPrice::whereHas('company', function (Builder $query) {
            $query->where('symbol', 'VTI');
        })->orderBy('closed_at', 'desc')->limit(20)->get();
        $vti_last_price = $vti_series[0]['close'];
        $vti_before_last_price = $vti_series[1]['close'];
        $vti_before_five_day_price = $vti_series[4]['close'];
        $vti_before_twenty_day_price = $vti_series[19]['close'];
        $vti_one_day_change = ($vti_last_price - $vti_before_last_price) / $vti_before_last_price;
        $vti_five_day_change = ($last_price - $vti_before_five_day_price) / $vti_before_five_day_price;
        $vti_twenty_day_change = ($last_price - $vti_before_twenty_day_price) / $vti_before_twenty_day_price;

        $vti_one_day_rel = ($one_day_change - $vti_one_day_change) / $vti_one_day_change;
        $vti_five_day_rel = ($five_day_change - $vti_five_day_change) / $vti_five_day_change;
        $vti_one_month_rel = ($twenty_day_change - $vti_twenty_day_change) / $vti_twenty_day_change;


        // 2.2 EMA
        // $ema20
        $series20 = HistoricalPrice::query()->select('close')->where('company_id', $company->id)->orderBy('closed_at', 'desc')->limit(120)->get();
        $flattened20 = array_reverse(Arr::flatten($series20->toArray()));
        $ema20 = trader_ema($flattened20, 20);
        $ema20 = end($ema20);



        // $ema60
        $series60 = HistoricalPrice::query()->select('close')->where('company_id', $company->id)->orderBy('closed_at', 'desc')->limit(180)->get();

        $flattened60 = array_reverse(Arr::flatten($series60->toArray()));
        $ema60 = trader_ema($flattened60, 60);
        $ema60 = end($ema60);


        // $ema120
        $series120 = HistoricalPrice::query()->select('close')->where('company_id', $company->id)->orderBy('closed_at', 'desc')->limit(300)->get();
        $flattened120 = array_reverse(Arr::flatten($series120->toArray()));
        $ema120 = trader_ema($flattened120, 120);
        $ema120 = end($ema120);

        $price_divergence_cs = ($last_price - $ema20) / $ema20 * 100;

        $price_divergence_sm = ($ema20 - $ema60) / $ema60 * 100;

        $price_divergence_ml = ($ema60 - $ema120) / $ema120 * 100;

        // 3. 写入数据库

        try {
            DB::beginTransaction();
            ActiveStock::updateOrCreate(
                ['company_id' => $company->id, 'calculated_at' => $calculated_at],
                [
                    'last_price' => $last_price, 'before_last_price' => $before_last_price,
                    'one_day_change' => $one_day_change, 'vti_one_day_rel' => $vti_one_day_rel,
                    'vti_five_day_rel' => $vti_five_day_rel, 'vti_one_month_rel' => $vti_one_month_rel,
                    'price_divergence_cs' => $price_divergence_cs, 'price_divergence_sm' => $price_divergence_sm, 'price_divergence_ml' => $price_divergence_ml, 'last_tradvol' => $last_tradvol
                ]
            );
            DB::commit();
            $message = $company->symbol . ' ' . $calculated_at .  ' calculated';
            FileLog::calculate($message);
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        return 0;
    }
}
