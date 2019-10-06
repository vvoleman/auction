<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegpartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regparts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("region_id");
            $table->string("name");

            $table->foreign("region_id")->references("id")->on("regions");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regparts');
    }
}
