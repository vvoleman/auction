<?php

use Illuminate\Database\Seeder;

class PicturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $imgs = ["electronics.png","collections.png","cars.png","house.png"];
        foreach($imgs as $i){
            DB::table('pictures')->insert([
                "picture_path"=>"/category_pictures/".$i,
                "type_id"=>3,
                "creator_id"=>1
            ]);
        }
    }
}
