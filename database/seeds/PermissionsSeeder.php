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
            "offers.new","offers.edit","offers.offer","offers.renew","offers.delete","offers.search","offers.buy",
            "admin.dashboard","admin.categories","admin.groups","admin.users",
            "chat.chat"
    	];
    	foreach($perms as $p){
    		DB::table('permissions')->insert(["permission"=>$p]);
    	}
    }
}
