<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBlogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_blogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string("title");
            $table->longText("body");
            $table->longText("summary");
            $table->string("author");
            $table->string("context");
            $table->string("domain");
            $table->string("url");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_blogs');
    }
}
