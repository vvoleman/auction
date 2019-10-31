<?php

use Illuminate\Database\Seeder;

class OfferTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("offer_types")->insert([
            "name"=>"Aukce"
        ]);
        DB::table("offer_types")->insert([
            "name"=>"Prodej"
        ]);
    }
}
