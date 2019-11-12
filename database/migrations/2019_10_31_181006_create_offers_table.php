<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->increments('id_o');
            $table->string("name",64);
            $table->unsignedInteger("type_id");
            $table->unsignedInteger("currency_id");
            $table->unsignedInteger("payment_type_id");
            $table->unsignedInteger("delivery_type_id");
            $table->decimal("price",8,2);
            $table->timestamp("end_date");
            $table->text("description");
            $table->unsignedInteger("owner_id");
            $table->string("delete_reason",32)->nullable();
            $table->string("uuid",16);
            $table->timestamps();

            $table->foreign("type_id")->references("id_ot")->on("offer_types");
            $table->foreign("owner_id")->references("id_u")->on("users");
            $table->foreign("currency_id")->references("id_c")->on("currencies");
            $table->foreign("payment_type_id")->references("id_pt")->on("payment_types");
            $table->foreign("delivery_type_id")->references("id_dt")->on("delivery_types");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
