@extends('mains.main')
@section('title','Profil | ')
@section('content')
    <div class="d-md-flex justify-content-around col-lg-8 mx-auto align-items-start">
        <div class="col-xl-3 col-md-4 white_box m-top3">
            @if($you)
            <div class="row justify-content-end" style="margin-right:5px">
                <a href="{{route('setting.setting')}}" class="fas fa-cog text-muted"></a>
            </div>
            @endif
            <div>
                <img class="mx-auto img_bubble d-block" src="{{$user->profpic_path()}}" width="100px">
                <h4 class="text-center d-block m-top">{{$user->fullname}}</h4>
                <div class="info_box d-flex justify-content-center col-12 flex-wrap">
                    <div><img src="{{$user->country->img}}" class="flag-sm">{{$user->region->name}}</div>
                    <div>Naposledy přihlášen: <span class="d-block bold">{{$user->last_logged->diffForHumans()}}</span></div>
                </div>
            </div>
        </div>
        <div class="col-xl-7 col-md-6 white_box m-top3">
            <div class="">
                <h4 class="text-muted">@if($you) Vaše nabídky @else Nabídky @endif</h4>
            </div>
        </div>
    </div>
@stop
