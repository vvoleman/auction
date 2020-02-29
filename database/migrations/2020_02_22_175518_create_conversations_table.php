<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConversationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->increments('id_c');
            $table->unsignedInteger("color_id");
            $table->string("uuid",8);
            $table->dateTime("created_at")->useCurrent();
            $table->dateTime("updated_at")->useCurrent();

            $table->foreign("color_id")->references("id_c")->on("colors");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conversations');
    }
}
