<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreInfomationToCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            //
            $table->string('stock_market')->nullable()->comment('Stock Market');
            $table->string('logo_id')->nullable()->comment("Company's Logo ID");
            $table->bigInteger('volume')->nullable()->comment("VOL");
            $table->decimal('market_cap_basic', 20, 4)->nullable()->comment("MKT CAP");
            $table->decimal('price_earnings_ttm', 11, 4)->nullable()->comment("P/E");
            $table->decimal('earnings_per_share_basic_ttm', 11, 4)->nullable()->comment("EPS(TTM)");
            $table->bigInteger('number_of_employees')->nullable()->comment("EMPLOYEES");
            $table->string('sector')->nullable()->comment("SECTOR");
            $table->boolean('is_spx')->default(false)->comment("is s & p 500");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['stock_market', 'logo_id', 'volume', 'market_cap_basic', 'price_earnings_ttm', 'earnings_per_share_basic_ttm', 'number_of_employees', 'sector', 'is_spx']);
        });
    }
}
