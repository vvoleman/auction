<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroPerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gro_per', function (Blueprint $table) {
            $table->unsignedInteger("group_id");
            $table->unsignedInteger("perm_id");
            $table->timestamp("added_at")->useCurrent();
            $table->timestamp("deleted_at")->nullable();

            $table->foreign("group_id")->references("id_g")->on("groups");
            $table->foreign("perm_id")->references("id_p")->on("permissions");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gro_per');
    }
}
