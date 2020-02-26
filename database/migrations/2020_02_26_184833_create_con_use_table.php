<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConUseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('con_use', function (Blueprint $table) {
            $table->unsignedInteger("conversation_id");
            $table->unsignedInteger("user_id");

            $table->foreign("conversation_id")->references("id_c")->on("conversations");
            $table->foreign("user_id")->references("id_u")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('con_use');
    }
}
