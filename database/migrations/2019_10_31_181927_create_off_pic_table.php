<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffPicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('off_pic', function (Blueprint $table) {
            $table->unsignedInteger("offer_id");
            $table->unsignedInteger("picture_id");
            $table->boolean("deleted_at")->nullable();

            $table->foreign("offer_id")->references("id_o")->on("offers");
            $table->foreign("picture_id")->references("id_p")->on("pictures");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('off_pic');
    }
}
