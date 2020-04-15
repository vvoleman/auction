<?php

use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //osobně
        //dobírka
        //online
        DB::table("payment_types")->insert([
            "name"=>"personal",
            "label"=>"Osobně",
            "delivery_type_id"=>1
        ]);
        /*DB::table("payment_types")->insert([
            "name"=>"ondelivery",
            "label"=>"Dobírka",
            "delivery_type_id"=>2
        ]);
        DB::table("payment_types")->insert([
            "name"=>"online",
            "label"=>"Online",
        ]);*/
    }
}
