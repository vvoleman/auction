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
        $now = Carbon::now();
        DB::table('users')->insert([
            "firstname"=>"Alice",
            "surname"=>"Nováková",
            "email"=>"alice@auction.com",
            "password"=>Hash::make("heslo123"),
            "group_id"=>2,
            "uuid"=>Str::random(8),
            "region_id"=>6,
            "city"=>"Hrotovice",
            "zipcode"=>"67555",
            "address"=>"Sokolská 892",
            "activation_token"=>Str::random(16),
            "email_verified_at"=>Carbon::now(),
            "created_at"=>$now,
            "updated_at"=>$now
        ]);
        DB::table('users')->insert([
            "firstname"=>"Karel",
            "surname"=>"Němec",
            "email"=>"knemec@auction.com",
            "password"=>Hash::make("heslo123"),
            "group_id"=>1,
            "uuid"=>Str::random(8),
            "region_id"=>6,
            "city"=>"Litencice",
            "zipcode"=>"76813",
            "address"=>"Petrželka 1597",
            "activation_token"=>Str::random(16),
            "email_verified_at"=>Carbon::now(),
            "created_at"=>$now,
            "updated_at"=>$now
        ]);
        DB::table('users')->insert([
            "firstname"=>"Jan",
            "surname"=>"Dvořák",
            "email"=>"jdvorak@auction.com",
            "password"=>Hash::make("heslo123"),
            "group_id"=>1,
            "uuid"=>Str::random(8),
            "region_id"=>6,
            "city"=>"Praha",
            "zipcode"=>"15500",
            "address"=>"5. máje 272/57",
            "activation_token"=>Str::random(16),
            "email_verified_at"=>Carbon::now(),
            "created_at"=>$now,
            "updated_at"=>$now
        ]);
    }
}
