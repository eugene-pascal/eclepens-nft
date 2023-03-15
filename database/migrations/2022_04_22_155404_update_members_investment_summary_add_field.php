<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMembersInvestmentSummaryAddField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members_investment_summary', function (Blueprint $table) {
            $table->unsignedDecimal('daily_profit_usd', 10, 2)->default('0')->after('total_profit_usd');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('members_investment_summary', function (Blueprint $table) {
            $table->dropColumn('daily_profit_usd');
        });
    }
}
