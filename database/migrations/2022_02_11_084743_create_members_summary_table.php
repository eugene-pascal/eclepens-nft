<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersSummaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members_account_summary', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('account_number');
            $table->date('validity_date');
            $table->string('strategy_type', 32)->default('balanced');
            $table->string('capitalization_status', 32)->default('disabled');
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
        Schema::dropIfExists('members_account_summary');
    }
}
