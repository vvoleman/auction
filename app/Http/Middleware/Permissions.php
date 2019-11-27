<?php

namespace App\Http\Middleware;

use Closure;

class Permissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,...$perms)
    {
        if(\Auth::check()){
            $user = $request->user();
            foreach($perms as $p){
                if(!$user->hasPermission($p)){
                    if($request->ajax()){
                        return response()->json([
                            "response"=>403,
                            "message"=>"Not Authorized!"
                        ],403);
                    }
                    $request->session()->flash("danger","Přístup zamítnut! K této činnosti nemáte oprávnění!");
                    return redirect()->back();
                }
            }
            return $next($request);
        }else{
            return redirect()->route('login.login');
        }
    }
}
