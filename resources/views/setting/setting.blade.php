@extends('mains/main')
@section('title','Nastavení profilu | ')
@section('content')
    <div class="col-md-4 mx-auto white_box m-top3">
        <h3>Nastavení</h3>
    </div>
    <div class="col-md-4 mx-auto white_box m-top">
        <h5>E-mail</h5>
        <form method="post" action="{{route('emailchange.store')}}" id="emailform">
            @csrf
            <div class="form">
                <div class="form-group">
                    <input type="email" name="email" value="{{$email}}" class="form-control">
                </div>
                <input type="submit" class="btn btn-block btn-blue" value="Změnit" id="emailbtn">
            </div>
        </form>
    </div>
    <div class="col-md-4 mx-auto white_box m-top">
        <form method="post" action="{{route('setting.postSetting')}}" id="settingform">
            @csrf
            @include('partials/_formmsgs')
            <div class="form">
                <div class="form-group">
                    <h5>Jméno</h5>
                    <input type="text" name="firstname" value="{{$firstname}}" class="form-control">
                </div>
                <div class="form-group">
                    <h5>Příjmení</h5>
                    <input type="text" name="surname" value="{{$surname}}" class="form-control">
                </div>
                <div class="form-group">
                    <h5>Stát</h5>
                    <select class="form-control" id="countryselect">
                        @foreach($countries as $c)
                            <option value="{{$c->short}}" {{($country_id == $c->id_c) ? "selected" : ""}}>{{$c->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <h5>Kraj</h5>
                    <select class="form-control" id="regionselect" name="region_id">

                    </select>
                </div>
                <input type="submit" class="btn btn-block btn-blue" disabled id="settingbtn" value="Změnit">
            </div>
        </form>
    </div>
@stop
@section("scripts")
    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.15/lodash.min.js"></script>
    <script src="{{URL::asset('/assets/js/custom/settings/regionsLoader.js')}}"></script>
    <script src="{{URL::asset('/assets/js/custom/settings/isItSame.js')}}"></script>
    <script>
        new RegionsLoader('{!! $regions->toJSON() !!}',{{$region_id}});
        const settingchanges = new FormChanges({!! json_encode(["firstname"=>$firstname,"surname"=>$surname,"region_id"=>''.$region_id])!!});
        const emailchanges = new FormChanges({!! json_encode(["email"=>$email]) !!});

        $("#settingform :input").on('keyup',checkEqual).on('change',function(){
            const obj = {
                firstname:$("input[name=firstname]").val(),
                surname:$("input[name=surname]").val(),
                region_id:$("select[name=region_id]").val()
            };
            $("#settingbtn").attr('disabled',!settingchanges.somethingNew(obj));
        });

        $("#emailform :input").on('keyup',function() {
            const obj = {email:$("input[name=email]").val()};
            $("#emailbtn").attr('disabled',!emailchanges.somethingNew(obj));
        });

    </script>
@stop
