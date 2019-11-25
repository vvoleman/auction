<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\Requests\DeleteGroup;
use App\Http\Requests\EditGroup;
use App\Permission;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminGroupsController extends Controller
{
    private $default_group = 1; //uživatel
    public function getGroups(){
        return view("admin/configure/groups");
    }

    public function ajaxGetGroups(){
        $groups = Group::all()->map(function($x){
            $x->isDefault = $x->id_g == $this->default_group;
        });
        return $groups;
    }
    public function ajaxEditGroup(EditGroup $request){
        $data = $request->validated();

        $group = Group::find($data["id"]);

        //zjistit permise
        if(!empty($data["permissions"])){
            $permise = $this->checkPermIds($data["permissions"]);
        }else{
            $permise = [];
        }

        //zkontroluje jestli existuje
        //upravit obsahující
        //smazat neobsahující
        //přidat nový
        $already_defined = $group->permissions;
        foreach($permise as $p){
            if($already_defined->where("id_p",$p)->count() == 0){ //přidání
                $group->permissions()->attach($p);
            }else{ //žádná změna
                $already_defined->pull($already_defined->search(function($x) use($p) {
                    return $x->id_p == $p;
                }));
            }
        }
        foreach($already_defined as $ad){ //maže starý
            $group->permissions()->updateExistingPivot($ad, [
                "deleted_at" => Carbon::now()
            ]);
        }

        $group->name = $data["name"];

        try{
            $group->save();
            return [
                "done"=>true,
                "group"=>$group
            ];
        }catch (\Exception $e){
            return [
                "done"=>false
            ];
        }

    }
    public function ajaxDeleteGroup(DeleteGroup $request){
        $data = $request->validated();

        $old = Group::find($data["delete_group"]);

        //zmen uzivatele z old na new
        foreach($old->users as $u){
            $u->group_id = $data["move_users_to"];
        }
        $old->deleted = Carbon::now();
        try{
            $old->save();
            return [
                "done"=>true
            ];
        }catch(\Exception $e){
            return ["done"=>false];
        }
    }
    public function ajaxNewGroup(Request $request){
        $data = $request->validate([
            "name"=>"required|string",
            "permissions"=>"nullable|array"
        ]);

        if(!empty($data["permissions"])){
            $permise = $this->checkPermIds($data["permissions"]);
        }else{
            $permise = [];
        }

        $group = Group::create([
            "name"=>$data["name"]
        ]);
        $group->attach($permise);

        try{
            $group->save();

            return [
                "done"=>true,
                "group"=>$group
            ];
        }catch (\Exception $e){
            return [
                "done"=>false
            ];
        }
    }
    public function ajaxGetPermissions(){
        return Permission::all();
    }

    private function checkPermIds($arr){
        $permise = [];
        if(!empty($data["permissions"])){
            foreach($data["permissions"] as $p){
                if(Permission::where('id_p',$p)->exists()){
                    $permise = intval($p);
                }
            }
        }
    }
}
