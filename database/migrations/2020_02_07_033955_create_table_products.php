<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string("name");
            $table->longText("Description", 1000);
            $table->string("context");
            $table->string("domain");
            $table->string("url");
            $table->string("image_url");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_products');
    }
}
