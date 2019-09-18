<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pictures')->insert([
            "firstname"=>"Vojtěch",
            "surname"=>"Voleman",
            "email"=>"vojtavol@email.cz",
            "picture_id"=>1,
            "password"=>"$2y$12$2Zm7rkv5fFpzlzF/NJBpoOMnN/jxp3BwWTUMs3sQ9rYpbjJZaHLdW"
        ]);
    }
}
