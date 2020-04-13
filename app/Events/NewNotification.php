<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Notification;

class NewNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $uuid;
    public $data;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user,$data)
    {
        $this->uuid = $user->uuid;

        $n = Notification::create($data);
        $n->users()->attach([$user->id_u]);
        $n->save();
        $this->data = [
            "icon"=>$n->type->icon,
            "title"=>$n->notification,
            "not_id"=>$n->id_n,
            "url"=>$n->url,
            "time"=>"právě teď",
            "seen"=>false
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {

        return new PrivateChannel('user.notifications.'.$this->uuid);
    }
}
