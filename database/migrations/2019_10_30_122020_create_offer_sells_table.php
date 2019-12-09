<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfferSellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_sells', function (Blueprint $table) {
            $table->increments('id_os');
            $table->unsignedInteger("buyer_id");
            $table->unsignedInteger("offer_id");
            $table->string("address")->nullable();
            $table->string("name")->nullable();
            $table->dateTime("confirmed_at")->nullable();
            $table->dateTime("deleted_at")->nullable();
            $table->dateTime("received_at")->nullable();
            $table->dateTime("created_at")->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offer_sells');
    }
}
