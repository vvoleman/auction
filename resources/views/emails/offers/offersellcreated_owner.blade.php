@extends('mains.email')
@section('content')
    <div class="text col-12">
        <div class="text-center">Nová žádost o koupi "{{$os["offer_name"]}}" byla podána {{$os["date"]}} uživatelem {{$os["buyer_fullname"]}}</div>
    </div>
@stop
