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
        $not_user = ["admin.dashboard","admin.categories","admin.groups","admin.users"];
        $all = \App\Permission::all();
        foreach($all as $a){
            DB::table('gro_per')->insert([
                "group_id"=>2,
                "perm_id"=>$a->id_p
            ]);
            if(!in_array($a->permission,$not_user)){
                DB::table('gro_per')->insert([
                    "group_id"=>1,
                    "perm_id"=>$a->id_p
                ]);
            }
        }
    }
}
