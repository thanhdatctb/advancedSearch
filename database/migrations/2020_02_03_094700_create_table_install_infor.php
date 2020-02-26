<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableInstallInfor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_install_infor', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string("clientId");
            $table->string("clientSecret");
            $table->string("code", 1000);
            $table->string("scope", 1000);
            $table->string("context")->index();
            $table->string("accessToken");
            $table->string("userId");
            $table->string("username");
            $table->string("email");
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
        Schema::dropIfExists('table_install_infor');
    }
}
