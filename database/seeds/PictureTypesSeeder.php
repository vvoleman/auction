<?php

use Illuminate\Database\Seeder;

class PictureTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('picture_types')->insert([
            'name' => "profile_picture",
            'label'=> "Profilový obrázek"
        ]);
    }
}
