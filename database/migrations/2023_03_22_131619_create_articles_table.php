<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable()->unique();
            $table->char('code_lang2',2)->index();
            $table->string('code_unique',32)->nullable()->unique();
            $table->string('code_name',8)->index();
            $table->string('title',255);
            $table->longText('text')->nullable();
            $table->string('meta_title', 255)->default('');
            $table->string('meta_description',512)->default('');
            $table->string('meta_keywords', 512)->default('');
            $table->boolean('display')->index();
            $table->dateTime('published_at')->useCurrent()->index();
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
        Schema::dropIfExists('articles');
    }
}
