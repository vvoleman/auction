<?php

use Illuminate\Database\Seeder;

class CurrenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currencies')->insert([
            "name"=>"Koruna česká",
            "short"=>"CZK"
        ]);
        DB::table('currencies')->insert([
            "name"=>"Euro",
            "short"=>"EUR"
        ]);
    }
}
