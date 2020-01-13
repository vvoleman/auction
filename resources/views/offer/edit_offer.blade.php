@extends('mains/main')
@section('title','Úprava nabídky | ')
@section('content')
    @component('partials._breadcrumbs')
        <li><a href="{{route('offers.offer',["id"=>$offer->uuid])}}">Nabídka</a></li>
        <li><a class="current">Úprava nabídky</a></li>
    @endcomponent
    <form method="post" action="{{route('offers.postEdit',["id"=>$offer->uuid])}}">
        @csrf
    <edit-offer dat="{{$data->toJson(JSON_UNESCAPED_UNICODE)}}"></edit-offer>
    </form>
    <edit-images images="{{$images->toJson(JSON_UNESCAPED_UNICODE)}}" token="{{$offer->uuid}}" class="col-md-8 mx-auto"></edit-images>
    <!--
        <div class="col-md-8 mx-auto white_box m-top3 d-flex justify-content-between align-items-start flex-wrap">
            @include('partials._formmsgs')
            <div class="col-12 text-center">
                <h1>Upravit nabídku</h1>
                <hr>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Název</label>
                    <input type="text" class="form-control" name="name" value="{{$offer->name}}">
                </div>
                <div class="form-group">
                    <label>Typ</label>
                    <select class="form-control" disabled>
                        <option>{{$offer->type->name}}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Otevřeno do</label>
                    <input type="datetime-local" disabled class="form-control"
                           value="{{$offer->end_date->toDateTimeLocalString()}}">
                </div>
                <div class="form-group">
                    <label>Popisek</label>
                    <div class="loader"></div>
                    <div class="description" style="display:none;">
                        <textarea class="form-control" name="description">{{$offer->description}}</textarea>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Měna</label>
                    <select class="form-control" disabled>
                        <option>{{$offer->currency->name}}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Doprava</label>
                    <select id="delivery" class="form-control" disabled>
                        <option>{{$offer->delivery_type->label}}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Typ platby</label>
                    <select id="payments" class="form-control" disabled>
                        <option>{{$offer->payment_type->label}}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Cena</label>
                    <input type="number" class="form-control" disabled value="{{$offer->price}}">
                </div>
                <div class="form-group">
                    <label>Tagy</label>
                    <input autocomplete="off" type="text" id="new_tag" class="form-control">
                    <div class="invalid-feedback" id="tags_msg" style="display:none">
                        Prosím, zadejte pouze slova a písmena!
                    </div>
                    <div class="tags" id="tag_container">
                    </div>
                </div>

            </div>
            <input type="hidden" name="_tags" id="_tags">
            <input type="submit" class="btn btn-blue btn-block">
        </div>
        !-->
    @if(Auth::user()->hasPermission("offers.delete"))
    <form id="end_form" method="post" action="{{route("offers.delete",["id"=>$offer->uuid])}}">
        @csrf
        <div class="white_box col-md-8 mx-auto m-top m-bot">
            <h1 class="text-center">Smazat nabídku</h1>
            <hr class="col-md-6 mx-auto">
            <div class="col-md-4 mx-auto">
                <textarea name="reason" class="form-control" placeholder="Důvod smazání (nepovinné)"></textarea>
                <button type="button" id="end_offer" class="btn btn-danger m-top btn-block">Smazat</button>
            </div>
        </div>
    </form>
    @endif
@stop
@section('scripts')
    <script>
        $("#end_offer").on('click',()=>{
           if(confirm("Opravdu chcete smazat nabídku? Tento krok nelze změnit!")){
               $("#end_form").submit();
           }
        });
    </script>
@stop
