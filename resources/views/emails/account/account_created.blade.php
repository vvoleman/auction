@extends('mains.email')
@section('content')
    <div class="text col-12">
        <div class="text-center">Váš účet byl úspěšně vytvořen! Jediné co vás dělí od využívání Bidderu je jeho potvrzení!</div>
        <a href="{{$url}}"><b class="text-center d-block">Pro potvrzení klikněte zde</b></a>
    </div>
@stop
