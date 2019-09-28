@extends('mains.email')
@section('content')
    <div class="text col-12">
        <div class="text-center">Resetujte si Vaše kliknutím na odkaz níže. Odkaz je platný po dobu jedné hodiny</div>
        <a href="{{$url}}"><b class="text-center d-block">Reset hesla</b></a>
    </div>
@stop
