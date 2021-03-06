<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePicturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pictures', function (Blueprint $table) {
            $table->increments('id_p');
            $table->string("picture_path");
            $table->unsignedInteger("creator_id");
            $table->unsignedInteger("type_id");
            $table->timestamp("created_at")->useCurrent();

            $table->foreign("type_id")->references("id_pt")->on("picture_types");
            $table->foreign("creator_id")->references("id_u")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pictures');
    }
}
