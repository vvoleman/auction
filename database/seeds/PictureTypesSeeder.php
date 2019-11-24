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
        DB::table('picture_types')->insert([ //1
            'name' => "profile_picture",
            'label'=> "Profilový obrázek"
        ]);
        DB::table('picture_types')->insert([ //2
            'name' => "offer_picture",
            'label'=> "Obrázek k nabídce"
        ]);
        DB::table('picture_types')->insert([ //3
            'name' => "category_picture",
            'label'=> "Obrázek kategorie"
        ]);
    }

}
