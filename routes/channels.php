<?php

use \App\User;
use App\OfferSell;
/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('user.messages.{userUuid}',function($user,$userUuid){
    $u = User::where('uuid',$userUuid)->first();
    if($u == null) return false;
    return $user->uuid === $u->uuid;
});
Broadcast::channel('user.notifications.{userUuid}',function($user,$userUuid){
	$u = User::where('uuid',$userUuid)->first();
    if($u == null) return false;
    return $user->uuid === $u->uuid;
});
Broadcast::channel('user.indicator.{userUuid}',function($user,$userUuid){
    $u = User::where('uuid',$userUuid)->first();
    if($u == null) return false;
    return $user->uuid === $u->uuid;
});

Broadcast::channel('offer.activity.${offerId}',function($user){
	return $user;
});

Broadcast::channel('offersell.info.{osId}',function($user,$osId){
    $os = OfferSell::where('id_os',$osId)->first();
    if($os == null) return false;
    return true;

    return $user->id_u == $os->buyer->id_u || $user->id_u == $os->offer->owner->id_u;
});
