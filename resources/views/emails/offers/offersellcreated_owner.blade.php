@extends('mains.email')
@section('content')
    <div class="text col-12">
        <div class="text-center">Nová žádost o koupi "{{$os->offer->name}}" byla podána {{$os->created_at->format("d. m. y H:i")}} uživatelem {{$os->buyer->fullname}}</div>
    </div>
@stop
