<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersInvestmentSummaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members_investment_summary', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedDecimal('invested_usd', 10, 2);
            $table->char('returned_btc', 20);
            $table->unsignedDecimal('total_profit_usd', 10, 2)->default('0');
            $table->unsignedDecimal('withdrawn_profit_usd', 10, 2)->default('0');
            $table->unsignedDecimal('current_profit_usd', 10, 2)->default('0');
            $table->foreignId('member_id')
                ->constrained()
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members_investment_summary');
    }
}
