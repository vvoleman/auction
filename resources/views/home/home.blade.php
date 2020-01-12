@extends('mains/main')
@section('title','Úvod | ')
@section('content')
    <div class="home-background" style="background-image: url('{{URL::asset('/assets/images/bg.jpeg')}}')">
        <div class="mask">
            <div class="content col-md-8">
                <div class="title d-flex justify-content-center mx-auto">
                    <h3>Hledejte...</h3>
                    <a id="word"><h3 class="marked" style="margin-left:10px;"></h3></a>
                </div>
                <div class="input">
                    <form method="get" action="{{route('search.search')}}">
                        <div class="d-flex justify-content-center align-items-center">
                            <input name="q" class="col-md-6" type="text" autocomplete="off">
                            <button type="submit">Vyhledat</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
@section('scripts')
    <script>/*
        var items = [
            ['smysl života', "{{route('search.search',["q"=>'smysl života'])}}"],
            ['lampu', "{{route('search.search',["q"=>'lampa'])}}"],
            ['hodiny', "{{route('search.search',["q"=>'hodiny'])}}"],
            ['motorku', "{{route('search.search',["q"=>'motorka'])}}"]
        ];
        var fade = 500;
        var index = 0;
        $("#word").attr("href", items[index][1]);
        $("#word h3").text(items[index][0]).fadeIn(fade);
        index++;

        setInterval(() => {
            $("#word").attr("href", items[index][1]);
            $("#word h3").fadeOut(fade, () => {
                $("#word h3").text(items[index][0]).fadeIn(fade);
                index = (index + 1 + items.length) % items.length;
            });
        }, 5000);*/
    </script>
@stop
