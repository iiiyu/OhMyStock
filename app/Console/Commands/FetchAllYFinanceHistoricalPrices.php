<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Company;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Utils\Log\Facades\FileLog as FileLog;


class FetchAllYFinanceHistoricalPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:yf:historical:all {--range=5d}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch All Historical Stock Data  --range={ max 5y 2y 1y ytd 6m 3m 1m 1mm 5d 5dm date dynamic }';

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
        $rangeName = $this->option('range');
        $now =   Carbon::now()->toDateTimeString();
        $message = $now . ' Begin Sync';
        Log::channel('discord')->info($message);
        Company::chunk(20, function ($companies) use ($rangeName) {
            $this->info("Fetching");
            FileLog::fetchAll("Fetching");
            foreach ($companies as $company) {
                //
                $this->info('Fetching ' . $company->symbol);
                FileLog::fetchAll('Fetching ' . $company->symbol);
                $this->call('stock:yf:historical', [
                    'symbol' => $company->symbol,
                    '--range' => $rangeName,
                ]);
                $this->info('Finish Fetch ' . $company->symbol);
                $this->info('Calculator ' . $company->symbol);
                FileLog::fetchAll('Finish Fetch ' . $company->symbol);
                FileLog::fetchAll('Calculator ' . $company->symbol);
                $this->call('stock:active', [
                    'symbol' => $company->symbol
                ]);
                $this->info('Finish Calculator ' . $company->symbol);
                FileLog::fetchAll('Finish Calculator ' . $company->symbol);
            }
        });
        return 0;
    }
}
