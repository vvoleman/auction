<?php


namespace App\Http\View\Composers;
use Carbon\Carbon;
use Illuminate\View\View;
use App\User;
use Illuminate\Support\Facades\Auth;

class NotificationComposer
{
    private $user;
    public function __construct(){
        $this->user = Auth::user();
    }

    public function compose(View $view){
        if($this->user != null){
            $data = $this->user->notifications()->orderBy("created_at","desc")->get();
        }else{
            $data = collect();
        }
        //dd($data);
        $c = Carbon::now();
        $view->with('notifications',$data->map(function($x)use($c){
            return [
                "icon"=>$x->type->icon,
                "title"=>$x->notification,
                "not_id"=>$x->id_n,
                "url"=>$x->url,
                "time"=>($x->created_at->addDay() < $c) ? $x->created_at->format("d. m. y H:i") : $x->created_at->diffForHumans(),
                "seen"=>$x->pivot->seen_at != null
            ];
        }));

    }
}
