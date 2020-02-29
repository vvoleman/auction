<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id_m');
            $table->unsignedInteger("conversation_id");
            $table->unsignedInteger("from");
            $table->unsignedInteger("to");
            $table->dateTime("sent_at")->useCurrent();
            $table->text("message");
            $table->unsignedInteger("offer_id")->nullable();;
            $table->string("uuid",8);
            $table->dateTime("seen_at")->nullable();

            $table->foreign("conversation_id")->references("id_c")->on("conversations");
            $table->foreign("from")->references("id_u")->on("users");
            $table->foreign("to")->references("id_u")->on("users");
            $table->foreign("offer_id")->references("id_o")->on("offers");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
