<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHelpthreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('helpthreads', function (Blueprint $table) {
            $table->increments('id_ht');
            $table->string("title");
            $table->unsignedInteger("author_id");
            $table->text("text");
            $table->unsignedInteger("answer");
            $table->string("uuid","8");

            $table->datetime("created_at");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('helpthreads');
    }
}
