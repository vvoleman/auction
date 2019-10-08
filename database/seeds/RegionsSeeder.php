<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class RegionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $content = Storage::get("public/jsons/regions.json");
        $arr = json_decode($content,JSON_UNESCAPED_UNICODE);
        foreach ($arr as $a){
            DB::table('regions')->insert($a);
        }
    }
}
