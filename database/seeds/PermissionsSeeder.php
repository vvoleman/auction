<?php

use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$perms = [
    		"settings.setting","settings.email",
            "profile.profile","profile.pic_change",
            "offers.new","offers.edit","offers.offer","offers.renew","offers.delete","offers.search",
            "admin.categories","admin.groups","admin.users"
    	];
    	foreach($perms as $p){
    		DB::table('permissions')->insert(["permission"=>$p]);
    	}
    }
}
