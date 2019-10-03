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
    		"admin.admin", //can see admin panel
    		"admin.stats",
    		"admin.report.see",
    		"admin.report.decide",
    		"admin.helpdesk.reply",
    		"admin.helpdesk.setstatus",
    		"admin.category.add",
    		"admin.category.modify",
    		"admin.category.delete",
    		"admin.active",
    		"admin.reviews",
    		"admin.permissions.add",
    		"admin.permissions.delete"
    	];
    	foreach($perms as $p){
    		DB::table('permissions')->insert(["permission"=>$p]);
    	}
    }
}
