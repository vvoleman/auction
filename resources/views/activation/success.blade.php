@extends('mains.main')
@section('title','Potvrzení proběhlo úspěšně! |')
@section('content')
    <div class="col-md-4 mx-auto white_box text-center m-top3">
        <h4>Váš účet byl úspěšně ověřen!</h4>
        <i class="fas fa-check text-success m-top status_sign"></i>
        <a href="{{route('home.home')}}"><button class="btn btn-block m-top2 btn-blue">Domů</button></a>
    </div>
@stop
