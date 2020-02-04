@extends('mains.main')
@section('title','Neplatný ověřovací kód |')
@section('content')
    <div class="col-md-4 mx-auto white_box text-center m-top3">
        <h4>Neplatný ověřovací kód!</h4>
        <i class="fas fa-exclamation text-danger m-top status_sign"></i>
        <a href="{{route('home.home')}}"><button class="btn btn-block m-top2 btn-blue">Domů</button></a>
    </div>
@stop
