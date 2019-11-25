<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vals = [
            ["label"=>"Elektronika","color"=>"5E7395","p"=>1],
            ["label"=>"Sběratelství","color"=>"8F807A","p"=>2],
            ["label"=>"Auta","color"=>"E1DD91","p"=>3],
            ["label"=>"Dům a zahrada","color"=>"88C673","p"=>4],
        ];
        foreach($vals as $v){
            DB::table('categories')->insert([
                "label"=>$v["label"],
                "description"=>"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.",
                "picture_id"=>$v["p"],
                "color"=>$v["color"],
                "uuid"=>\Illuminate\Support\Str::random(4),
                "created_at"=>Carbon::now(),
                "updated_at"=>Carbon::now(),
            ]);
        }

    }
}
