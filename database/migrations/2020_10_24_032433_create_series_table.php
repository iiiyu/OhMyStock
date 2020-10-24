<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('company_id');
            $table->date('closed_at')->index()->comment('收盘时间');
            $table->enum('interval', ['Daily', 'Weekly', 'Monthly'])->comment('记录时间颗粒度');
            $table->decimal('open', 11, 4)->comment('开盘价格');
            $table->decimal('high', 11, 4)->comment('最贵价格');
            $table->decimal('low', 11, 4)->comment('最低价格');
            $table->decimal('close', 11, 4)->comment('收盘价格');
            $table->decimal('adjusted_close', 11, 4)->comment('复权后的收盘价');
            $table->bigInteger('volume')->comment('交易量');
            $table->decimal('dividend_amount', 11, 4)->comment('股息');
            $table->decimal('split_coefficient', 8, 2)->comment('拆股');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->unique(['company_id', 'closed_at', 'interval']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('series');
    }
}
