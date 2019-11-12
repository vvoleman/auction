<?php

use Illuminate\Database\Seeder;

class DeliveryTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("delivery_types")->insert([
            "name"=>"personal",
            "label"=>"Převzetí osobně"
        ]);
        DB::table("delivery_types")->insert([
            "name"=>"cp",
            "label"=>"Česká pošta"
        ]);
    }
}
