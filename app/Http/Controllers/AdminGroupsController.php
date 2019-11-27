<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\Requests\DeleteGroup;
use App\Http\Requests\EditGroup;
use App\Permission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AdminGroupsController extends Controller
{
    private $default_group = 1; //uživatel

    public function getGroups()
    {
        return view("admin/configure/groups");
    }

    public function ajaxGetGroups()
    {
        $groups = Group::where('deleted_at',null)->get()->map(function ($x) {
            $x->isDefault = $x->id_g == $this->default_group;
            $x->permissions = $x->permissions()->where('deleted_at', '=', null)->get();
            return $x;
        });
        return $groups;
    }
    public function ajaxEditGroup(EditGroup $request)
    {
        $data = $request->validated();

        $group = Group::find($data["id"]);

        //zjistit permise
        if (!empty($data["permissions"])) {
            $permise = $this->checkPermIds($data["permissions"]);
        } else {
            $permise = [];
        }

        //zkontroluje jestli existuje
        //upravit obsahující
        //smazat neobsahující
        //přidat nový
        $already_defined = $group->permissions()->where('deleted_at', null)->get();
        $attach = [];
        $not = [];
        foreach ($permise as $p) {
            if ($already_defined->where("id_p", $p)->count() == 0) { //přidání
                $group->permissions()->attach($p);
                $attach[] = $p;
            }
            $not[] = $already_defined->search(function ($x) use ($p) {
                return $x->id_p == $p;
            });
            $already_defined->forget($already_defined->search(function ($x) use ($p) {
                return $x->id_p == $p;
            }));
        }
        foreach ($already_defined as $ad) { //maže starý
            $added = $group->permissions()->where('deleted_at', null)->where('perm_id', $ad->id_p)->first();
            $group->permissions()->where("added_at", $added)->updateExistingPivot($ad->id_p, [
                "deleted_at" => Carbon::now()
            ]);
        }

        $group->name = $data["name"];

        try {
            $group->save();
            $group->isDefault = $group->id_g == $this->default_group;
            $group->permissions = $group->permissions()->where('deleted_at', '=', null)->get();
            return [
                "done" => true,
                "group" => $group
            ];
        } catch (\Exception $e) {
            return [
                "done" => false
            ];
        }

    }

    private function checkPermIds($arr)
    {
        $permise = [];
        if (!empty($arr)) {
            foreach ($arr as $p) {
                if (Permission::where('id_p', $p)->exists()) {
                    $permise[] = intval($p);
                }
            }
        }
        return $permise;
    }

    public function ajaxDeleteGroup(DeleteGroup $request)
    {
        $data = $request->validated();

        $old = Group::find($data["delete_group"]);

        //zmen uzivatele z old na new
        foreach ($old->users as $u) {
            $u->group_id = $this->default_group;
            $u->save();
        }
        $old->deleted_at = Carbon::now();
        try {
            $old->save();
            return [
                "done" => true
            ];
        } catch (\Exception $e) {
            return ["done" => false];
        }
    }
    public function ajaxNewGroup(Request $request)
    {
        $data = $request->validate([
            "name" => "required|string",
            "permissions" => "nullable|array"
        ]);

        if (!empty($data["permissions"])) {
            $permise = $this->checkPermIds($data["permissions"]);
        } else {
            $permise = [];
        }

        $group = Group::create([
            "name" => $data["name"]
        ]);
        $group->permissions()->attach($permise);

        try {
            $group->save();
            $group->permissions = $group->permissions()->where('deleted_at', '=', null)->get();
            return [
                "done" => true,
                "group" => $group
            ];
        } catch (\Exception $e) {
            return [
                "done" => false
            ];
        }
    }
    public function ajaxGetPermissions()
    {
        return Permission::all();
    }
    public function ajaxGetHistory(Request $request){
        $data = $request->validate([
            "group_id"=>"required|exists:groups,id_g"
        ]);
        $group = Group::where('id_g',$data["group_id"])->whereNull('deleted_at')->first();
        if($group == null){
            return [
                "response"=>404
            ];
        }
        $results = new Collection();
        $temp = $group->permissions;
        foreach($temp as $t){
            $results[] = [
                "date"=>strtotime($t->pivot->added_at),
                "text"=>"Oprávnění '{$t->permission}' přidáno",
                "deleted"=>false
            ]; //
            if($t->pivot->deleted_at != null){
                $results[] = [
                    "date"=>strtotime($t->pivot->deleted_at),
                    "text"=>"Oprávnění '{$t->permission}' smazáno",
                    "deleted"=>true
                ];
            }
        }
        $results = $results->sortBy('date')->values()->all();
        return $results;
    }

}
