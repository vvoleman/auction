<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotUseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('not_use', function (Blueprint $table) {
            $table->unsignedInteger("user_id");
            $table->unsignedInteger("notification_id");
            $table->dateTime("seen_at")->nullable();
            $table->dateTime("deleted_at")->nullable();

            $table->foreign("user_id")->references("id_u")->on("users");
            $table->foreign("notification_id")->references("id_n")->on("notifications");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('not_use');
    }
}
