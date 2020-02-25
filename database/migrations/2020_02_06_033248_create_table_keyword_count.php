<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableKeywordCount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_keyword_count', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string("key_word",1000);
            $table->integer("count");
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
        Schema::dropIfExists('table_keyword_count');
    }
}
