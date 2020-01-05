<?php


namespace App\Http\View\Composers;
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
            $data = $this->user->notifications;
        }else{
            $data = [];
        }
        //dd($data);

    }
}
