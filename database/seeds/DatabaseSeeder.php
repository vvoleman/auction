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
        $this->call(DeliveryTypesSeeder::class);
        $this->call(PaymentTypeSeeder::class);
        $this->call(CurrenciesSeeder::class);
        $this->call(CountriesSeeder::class);
        $this->call(RegionsSeeder::class);
        $this->call(GroupsSeeder::class);
        $this->call(PictureTypesSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(PicturesSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(OfferTypesSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(OfferSeeder::class);
        $this->call(GroPerSeeder::class);
        $this->call(PrioritiesSeeder::class);
        $this->call(NotificationTypesSeeder::class);
        $this->call(ColorsSeeder::class);
    }
}
