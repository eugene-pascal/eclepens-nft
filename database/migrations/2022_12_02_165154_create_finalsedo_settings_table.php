<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinalsedoSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finalsedo_settings', function (Blueprint $table) {
            $table->id();
            $table->string('username',16);
            $table->string('password',16);
            $table->string('partnerid',12);
            $table->string('signkey',32);
            $table->string('extra', 512);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finalsedo_settings');
    }
}
