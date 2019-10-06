@extends('mains.email')
@section('content')
    <div class="text col-12">
        <div class="text-center">Zažádali jste o změnu emailu.</div>
        <a href="{{$url}}"><b class="text-center d-block">Pro potvrzení klikněte zde</b></a>
    </div>
@stop
