<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaticPageLocalization extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('static_page_localization', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('static_page_id');
            $table->unsignedBigInteger('language_id');

            $table->string('name');
            $table->string('header');
            $table->longText('text')->nullable();
            $table->string('title');
            $table->text('description');
            $table->string('keywords')->nullable();
            $table->unique(['static_page_id', 'language_id'], 'unique_localization');
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
            $table->foreign('static_page_id')->references('id')->on('static_pages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('static_page_localization');
    }
}
