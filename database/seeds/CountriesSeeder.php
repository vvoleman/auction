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
            "img_path"=>"czechrepublic.png"
        ]);
        DB::table('countries')->insert([
            "name"=>"Slovenská republika",
            "short"=>"sk",
            "img_path"=>"slovakia.png"
        ]);
    }
}
