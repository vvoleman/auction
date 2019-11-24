@extends('mains.main')
@section('title','Profil | ')
@section('content')
    @component('partials._breadcrumbs')
        <li><a class="current">Profil</a></li>
    @endcomponent
    <div class="d-md-flex justify-content-around col-lg-10 mx-auto align-items-start">
        <div class="col-md-3 white_box m-top3">
            @if($you)
            <div class="row justify-content-end" style="margin-right:5px">
                <a href="{{route('setting.setting')}}" class="fas fa-cog text-muted"></a>
            </div>
            @endif
            <div>
                <a href="{{route("profile.profileimg")}}">
                    <img class="mx-auto img_bubble d-block" src="{{$user->profpic_path()}}" width="100px">
                </a>
                <h4 class="text-center d-block m-top">{{$user->fullname}}</h4>
                <div class="info_box d-flex justify-content-center col-12 flex-wrap">
                    <div><img src="{{$user->country->img}}" class="flag-sm">{{$user->region->name}}</div>
                    @if($user->last_logged)
                    <div class="d-block">Naposledy přihlášen:<span class="d-block" title="{{$user->last_logged->format('d. m. Y H:i')}}">{{$user->last_logged->diffForHumans()}}</span></div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-7 white_box m-top3">
            <div class="">
                <h4 class="text-muted">@if($you) Vaše nabídky @else Nabídky @endif</h4>
            </div>
        </div>
    </div>
@stop
