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
        $icons = [
            "offer"=>"fas fa-store-alt",
            "user"=>"fas fa-user",
            "message"=>"far fa-envelope"
        ];

        $types = [
            ["name"=>"offersell_created","priority_id"=>2,"icon"=>$icons["offer"]],
            ["name"=>"offersell_confirmed","priority_id"=>2,"icon"=>$icons["offer"]],
            ["name"=>"user_created","priority_id"=>2,"icon"=>$icons["user"]],
            ["name"=>"new_message","priority_id"=>2,"icon"=>$icons["message"]]
        ];

        DB::table('notification_types')->insert($types);
    }
}
