<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Company;


class FetchHistoricalAllStockData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:alpha:historical:all {--interval=daily}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch All Historical Stock Data  --interval={daily, weekily, monthly}';

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
        // $this->info("Building");
        // Artisan::command('stock:history {symbol}', function ($symbol) {
        //     $this->info("Building {$symbol}!");
        // })->describe('Build the project');
        Company::chunk(20, function ($companies) {
            $this->info("Fetching");
            foreach ($companies as $company) {
                //
                $this->info(sprintf('Fetching %s', $company->symbol));
                $this->call('stock:alpha:historical', [
                    'symbol' => $company->symbol
                ]);
                $this->info(sprintf('Finish Fetch %s', $company->symbol));

                $this->info(sprintf('Calculator %s', $company->symbol));
                $this->call('stock:active', [
                    'symbol' => $company->symbol
                ]);
                $this->info(sprintf('Finish Calculator %s', $company->symbol));
                sleep(20);
            }
        });


        return 0;
    }
}
