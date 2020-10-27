<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Company;


class FetchAllHistoricalPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:historical:all {--range=5d}';

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
        // $this->info("Building");
        // Artisan::command('stock:history {symbol}', function ($symbol) {
        //     $this->info("Building {$symbol}!");
        // })->describe('Build the project');
        $rangeName = $this->option('range');
        Company::chunk(20, function ($companies) use ($rangeName) {
            $this->info("Fetching");
            foreach ($companies as $company) {
                //
                $this->info(sprintf('Fetching %s', $company->symbol));
                $this->call('stock:historical', [
                    'symbol' => $company->symbol,
                    '--range' => $rangeName,
                ]);
                $this->info(sprintf('Finish Fetch %s', $company->symbol));

                $this->info(sprintf('Calculator %s', $company->symbol));
                $this->call('stock:active', [
                    'symbol' => $company->symbol
                ]);
                $this->info(sprintf('Finish Calculator %s', $company->symbol));
            }
        });


        return 0;
    }
}
