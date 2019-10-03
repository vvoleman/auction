<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_changes', function (Blueprint $table) {
            $table->increments('id_ec');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('verified_at')->nullable();
            $table->unsignedInteger("user_id");
            $table->string("email");
            $table->string("token",16)->unique();
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
        Schema::dropIfExists('email_changes');
    }
}
