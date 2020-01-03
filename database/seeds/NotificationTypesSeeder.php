<?php

use Illuminate\Database\Seeder;

class NotificationTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Offersell_created [for owner]
         * Offersell_confirmed [for buyer]
         */

        $types = [
            ["name"=>"offersell_created",2],
            ["name"=>"offersell_confirmed",2]
        ];
    }
}
