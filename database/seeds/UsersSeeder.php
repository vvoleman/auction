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
        DB::table('users')->insert([
            "firstname"=>"Vojtěch",
            "surname"=>"Voleman",
            "email"=>"vojtavol@email.cz",
            "password"=>"$2y$12$2Zm7rkv5fFpzlzF/NJBpoOMnN/jxp3BwWTUMs3sQ9rYpbjJZaHLdW"
        ]);
    }
}
