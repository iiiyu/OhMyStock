<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoricalPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historical_prices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('closed_at')->index()->comment('收盘时间');

            $table->unsignedBigInteger('company_id');

            $table->decimal('open', 11, 4)->nullable()->comment('Adjusted data for historical dates. Split adjusted only.');
            $table->decimal('high', 11, 4)->nullable()->comment('Adjusted data for historical dates. Split adjusted only.');
            $table->decimal('low', 11, 4)->nullable()->comment('Adjusted data for historical dates. Split adjusted only.');
            $table->decimal('close', 11, 4)->nullable()->comment('Adjusted data for historical dates. Split adjusted only.');
            $table->bigInteger('volume')->nullable()->comment('Adjusted data for historical dates. Split adjusted only.');

            $table->decimal('u_open', 11, 4)->nullable()->comment('Unadjusted data for historical dates.');
            $table->decimal('u_high', 11, 4)->nullable()->comment('Unadjusted data for historical dates.');
            $table->decimal('u_low', 11, 4)->nullable()->comment('Unadjusted data for historical dates.');
            $table->decimal('u_close', 11, 4)->nullable()->comment('Unadjusted data for historical dates.');
            $table->bigInteger('u_volume')->nullable()->comment('Unadjusted data for historical dates.');

            $table->decimal('change_over_time', 11, 4)->nullable()->comment('Percent change of each interval relative to first value. Useful for comparing multiple stocks.');
            $table->decimal('change', 11, 4)->nullable()->comment('Change from previous trading day.');
            $table->decimal('change_percent', 11, 2)->nullable()->comment('Change percent from previous trading day.');

            $table->foreign('company_id')->references('id')->on('companies');
            $table->unique(['company_id', 'closed_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historical_prices');
    }
}
