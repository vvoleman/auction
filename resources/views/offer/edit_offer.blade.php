@extends('mains/main')
@section('title','Nová nabídka | ')
@section('content')
    <form method="post" action="{{route('offers.postEdit',["id"=>$offer->uuid])}}">
        @csrf
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
                    <input type="datetime-local" class="form-control" value="{{\Carbon\Carbon::parse($offer->end_date)->format("Y-m-dTH:i:s")}}" @if($offer->type->name == "Prodej") name="end_date" @else disabled @endif>
                </div>
                <div class="form-group">
                    <label>Popisek</label>
                    <textarea class="form-control" name="description">{{$offer->description}}</textarea>
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
    </form>
@stop
@section('scripts')
    <script src="{{URL::asset("assets/js/xregexp.min.js")}}"></script>
    <script src="{{URL::asset("assets/js/custom/new_offer/tags.js")}}"></script>
    <script type="text/javascript">
        var tags = new Tags();
        tags.tags = JSON.parse('{!! $tags->toJson(JSON_UNESCAPED_UNICODE) !!}');
        tags.refresh();
        $("#new_tag").on('keypress', function (e) {
            if (e.which == 13) {
                e.preventDefault();
                temp = $("#new_tag").val();
                if(tags.check(temp)){
                    $("#tags_msg").hide();
                    if (temp.length > 2) {
                        tags.addTag(temp);
                        $("#new_tag").val("");
                    }
                }else{
                    $("#tags_msg").fadeIn();
                }
            }
        });
    </script>
@stop
