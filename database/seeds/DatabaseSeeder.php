<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CurrenciesSeeder::class);
        $this->call(CountriesSeeder::class);
        $this->call(RegionsSeeder::class);
        $this->call(GroupsSeeder::class);
        $this->call(PictureTypesSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(PicturesSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(OfferTypesSeeder::class);
    }
}
