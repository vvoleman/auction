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
        DB::table('pictures')->insert([
            "picture_path"=>"/users/profile_pics/abcd123.png",
            "creator_id"=1,
      		"type_id"=>1
        ]);
    }
}
