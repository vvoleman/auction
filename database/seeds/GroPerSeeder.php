<?php

use Illuminate\Database\Seeder;

class GroPerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $all = \App\Permission::all();
        foreach($all as $a){
            DB::table('gro_per')->insert([
                "group_id"=>2,
                "perm_id"=>$a->id_p
            ]);
        }
    }
}
