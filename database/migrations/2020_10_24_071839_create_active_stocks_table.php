<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActiveStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('active_stocks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('company_id');
            $table->date('calculated_at')->index()->comment('计算时间');
            $table->decimal('last_price', 11, 4)->default(0.0)->comment('最近价格');
            $table->decimal('before_last_price', 11, 4)->default(0.0)->comment('前一天价格');
            $table->decimal('one_day_change', 8, 4)->default(0.0)->comment('一天涨跌幅');
            $table->decimal('vti_one_day_rel', 10, 4)->default(0.0)->comment('一天相对vti的强度');
            $table->decimal('vti_five_day_rel', 10, 4)->default(0.0)->comment('五天相对vti的强度');
            $table->decimal('vti_one_month_rel', 10, 4)->default(0.0)->comment('一个月相对vti的强度');
            $table->decimal('price_divergence_cs', 10, 4)->default(0.0)->comment('价格乖离率cs');
            $table->decimal('price_divergence_sm', 10, 4)->default(0.0)->comment('价格乖离率sm');
            $table->decimal('price_divergence_ml', 10, 4)->default(0.0)->comment('价格乖离率ml');
            $table->bigInteger('last_tradvol')->default(0)->comment('交易量');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->unique(['company_id', 'calculated_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('active_stocks');
    }
}
