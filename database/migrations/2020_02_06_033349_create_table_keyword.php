<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableKeyword extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_keyword', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->dateTime("search_at");
            $table->string("key_word",1000);
            $table->string("domain");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_keyword');
    }
}
