<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatisticProfitFromApiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistic_profit_from_api', function (Blueprint $table) {
            $table->id();
            $table->date('day')->index();
            $table->unsignedDecimal('profit', 10, 6)->default('0');
            $table->string('strategy', 16)->default('balanced');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statistic_profit_from_api');
    }
}
