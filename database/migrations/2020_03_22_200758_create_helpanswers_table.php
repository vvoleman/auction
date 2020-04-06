<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHelpanswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('helpanswers', function (Blueprint $table) {
            $table->increments('id_ha');
            $table->unsignedInteger("thread_id");
            $table->unsignedInteger("author_id");
            $table->text("text");
            $table->string("uuid",8);

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
        Schema::dropIfExists('helpanswers');
    }
}
