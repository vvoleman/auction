<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id_u');
            $table->string('firstname');
            $table->string('surname');
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedInteger("region_id");
            $table->unsignedInteger("group_id")->nullable();
            $table->unsignedInteger("picture_id")->nullable();
            $table->timestamp('last_logged')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string("activation_token",16);
            $table->boolean('active')->default(1);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign("region_id")->references("id_r")->on("regions");
            //+cizi klice
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
