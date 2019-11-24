@extends('mains.main')
@section('title',"Změna profilového obrázku | ")
@section('content')
    @component('partials._breadcrumbs')
        <li><a href="{{route('profile.profile')}}">Profil</a></li>
        <li><a class="current">Profilový obrázek</a></li>
    @endcomponent
    <div class="col-md-8 mx-auto">
        <form enctype="multipart/form-data" method="post" action="{{route('profile.newProfileimg')}}">
            @csrf
            <div class="upload-btn-wrapper col-md-8 offset-md-2">
                <div class="uploadbtn_wrap d-flex justify-content-center align-items-center">
                    <i class="fas fa-upload"></i>
                    <span>Nahrát novou fotku</span>
                </div>
                <input type="file" name="image" id="imginput"/>
            </div>
            <div id="imgpreview" class="col-md-8 offset-md-2 m-top2" style="display:none">
                <img class="col-12">
                <input type="submit" class="btn btn-primary btn-block m-top" value="Nahrát">
            </div>
        </form>
        <form method="post" action="{{route('profile.oldProfileimg')}}">
            @csrf
            <div class="col-md-8 offset-md-2 m-top-50">
                <span class="d-block">nebo</span>
                <div>
                    <h4>Použít starší</h4>
                    <div class="col-md-12 d-md-flex flex-wrap">
                        @foreach(Auth::user()->old_profile_pictures as $p)
                            <div class="col-md-4 m-top">
                                <img draggable="false" class="col-12 old_img no-drag" src="{{$p->path}}" data="{{$p->id_p}}">
                            </div>
                        @endforeach
                    </div>
                </div>
                <button type="submit" id="oldsubmit" class="btn btn-success btn-block m-top" disabled>Změnit</button>
            </div>
            <input type="hidden" name="_data" id="_data">
        </form>
    </div>
@stop
@section('scripts')
    <script src="{{URL::asset('assets/js/custom/profile/profileImage.js')}}"></script>
    <script>
        const profileimage = new ProfileImage("#_data");
        $("#imginput").on('change', (e) => {
            profileimage.imageUploaded(e);
        });
        $(".old_img").on('click', (e) => {
            profileimage.oldClicked(e);
        })
    </script>
@stop
