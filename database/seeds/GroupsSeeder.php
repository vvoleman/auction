<?php

use Illuminate\Database\Seeder;

class GroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("groups")->insert([
            "name"=>"Uživatel"
        ]);
        DB::table("groups")->insert([
            "name"=>"Administrátor"
        ]);
    }
}
