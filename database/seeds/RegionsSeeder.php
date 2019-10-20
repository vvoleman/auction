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
        $regions = [
            [
                "id"=>1,
                "filename"=>"private/jsons/cz_regions.json"
            ],
            [
                "id"=>2,
                "filename"=>"private/jsons/sk_regions.json"
            ]
        ];
        foreach($regions as $r){
            $content = Storage::get($r["filename"]);
            $arr = json_decode($content,JSON_UNESCAPED_UNICODE);
            foreach ($arr as $a){
                $a["country_id"] = $r["id"];
                DB::table('regions')->insert($a);
            }
        }
    }
}
