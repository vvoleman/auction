@extends('mains.email')
@section('content')
    <div class="text col-12">
        <div class="text-center">Vaše žádost o koupi "{{$os["offer_name"]}}" byla podána. Nyní vyčkejte na její potvrzení prodejcem. O potvrzení vás budeme informovat.</div>
    </div>
@stop
