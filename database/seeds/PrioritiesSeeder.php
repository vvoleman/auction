<?php

use Illuminate\Database\Seeder;

class PrioritiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $priorities = [
            ["name"=>"Low"],
            ["name"=>"Medium"],
            ["name"=>"High"]
        ];

        DB::table('priorities')->insert($priorities);
    }
}
