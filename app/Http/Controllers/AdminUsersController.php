<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminGetUsers;
use App\Http\Requests\EditUserGroup;
use Illuminate\Http\Request;
use App\User;

class AdminUsersController extends Controller
{
    public function getUsers(){
        return view("admin/configure/users");
    }

    public function ajaxGetUsers(AdminGetUsers $request){
        $data = $request->validated();

        $limit = 10;

        $q = User::query();
        if(!empty($data["group_id"])){
            $q->where('group_id',$data["group_id"]);
        }
        $data["page"] = intval($data["page"]);
        $count = $q->count();
        $users = $q->skip($data["page"]*$limit)->take($limit)->get()->map(function($x){
            $x->group = $x->group->name;
            return $x;
        });
        $next = ($count-($data["page"]*$limit) > 0) ? $data["page"]+1 : false;

        return [
            "data"=>$users,
            "next"=>$next,
            "count"=>$count
        ];
    }
    public function ajaxEditUser(EditUserGroup $request){
        $data = $request->validated();

        $user = User::find($data["user_id"])->first();
        $user->group_id = $data["group_id"];
        try{
            $user->save();
            return [
                "done"=>true,
                "group"=>$user->group
            ];
        }catch (\Exception $e){
            return [
                "done"=>false
            ];
        }
    }
}
