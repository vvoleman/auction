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
            "name"=>"auction"
        ]);
        DB::table("offer_types")->insert([
            "name"=>"sale"
        ]);
    }
}
