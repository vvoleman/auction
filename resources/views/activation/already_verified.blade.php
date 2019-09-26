@extends('mains.main')
@section('title','Účet již byl potvrzen |')
@section('content')
    <div class="col-md-4 mx-auto white_box text-center m-top3">
        <h4>Tento účet už byl dříve potvrzen!</h4>
        <i class="fas fa-exclamation-triangle text-warning m-top status_sign"></i>
        <a href="{{route('home.home')}}"><button class="btn btn-block m-top2 btn-blue">Domů</button></a>
    </div>
@stop
