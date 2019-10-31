<?php

use Illuminate\Database\Seeder;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->insert([
            "name"=>"Česká republika",
            "short"=>"cz",
            "currency_id"=>1,
            "img_path"=>"czechrepublic.png"
        ]);
        DB::table('countries')->insert([
            "name"=>"Slovenská republika",
            "short"=>"sk",
            "currency_id"=>2,
            "img_path"=>"slovakia.png"
        ]);
    }
}
