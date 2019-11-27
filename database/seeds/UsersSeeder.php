<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            "firstname"=>"Vojtěch",
            "surname"=>"Voleman",
            "email"=>"vojtavol@email.cz",
            "password"=>Hash::make("heslo123"),
            "group_id"=>2,
            "uuid"=>Str::random(8),
            "region_id"=>6,
            "zipcode"=>"40003",
            "address"=>"Idk street 23",
            "activation_token"=>Str::random(16),
            "email_verified_at"=>Carbon::now()
        ]);
    }
}
