<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('sort')->nullable()->index();
            $table->string('lang_name', 64);
            $table->char('lang_code', 5)->index();
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });

        DB::insert(
            "INSERT INTO ".DB::getTablePrefix()."languages (sort, lang_name, lang_code, is_active, created_at,updated_at) values ('1','English','en','1',NOW(), NOW())"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('languages');
    }
}
