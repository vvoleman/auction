<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id_c');
            $table->string("label",64);
            $table->text("description");
            $table->unsignedInteger("picture_id");
            $table->string("color",6);
            $table->boolean('disabled')->default(false);
            $table->string("uuid",4)->unique();
            $table->timestamps();

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
        Schema::dropIfExists('categories');
    }
}
