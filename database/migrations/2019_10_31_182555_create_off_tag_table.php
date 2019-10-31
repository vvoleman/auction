<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('off_tag', function (Blueprint $table) {
            $table->unsignedInteger("offer_id");
            $table->unsignedInteger("tag_id");

            $table->foreign("offer_id")->references("id_o")->on("offers");
            $table->foreign("tag_id")->references("id_t")->on("tags");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('off_tag');
    }
}
