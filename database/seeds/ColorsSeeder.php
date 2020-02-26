<?php

use Illuminate\Database\Seeder;

class ColorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $colors = [
            ["hex"=>"3B4263","text_color"=>"white"],
            ["hex"=>"242424","text_color"=>"white"],
            ["hex"=>"F69ABF","text_color"=>"black"]
        ];
        DB::table("colors")->insert($colors);

    }
}
