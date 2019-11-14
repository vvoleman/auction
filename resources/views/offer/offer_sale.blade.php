@extends('mains.main')
@section('title',$offer->name." | ")
@section('content')
    <div class="col-md-8 mx-auto">
        <div class="row align-items-start">
            <div class="col-md-4 d-flex flex-wrap flex-column justify-content-between">
                <div class="col-12 white_box m-top test">
                    <img src="{{$offer->owner->profpic_path()}}" class="img_bubble mx-auto d-block" width="100px">
                    <h5 class="m-top text-center">{{$offer->owner->fullname}}</h5>
                    <div class="d-flex justify-content-center align-items-center"><img src="{{$offer->owner->country->img}}" class="flag-sm" style="margin-right: 5px;">{{$offer->owner->region->name}}</div>
                    <hr>
                    <div class="text-center">
                        <span class="offer_info"><b>15</b> nabídek</span>
                        <span><b>4,7</b> <i class="fas fa-star text-danger"></i></span>
                    </div>
                </div>
                <div class="col-12 white_box m-top test">
                    <h5 class="text-center">Základní informace</h5>
                    <hr>
                    <div class="col-12 d-flex flex-wrap mx-auto">
                        <div class="col-md-6 offer-item-info delivery">
                            <i class="fas fa-truck" title="Doprava"></i>
                            <span>{{$offer->delivery_type->label}}</span>
                        </div>
                        <div class="col-md-6 offer-item-info payment">
                            <i class="far fa-money-bill-alt" title="Platba"></i>
                            <span>{{$offer->payment_type->label}}</span>
                        </div>
                        <div class="col-md-6 offer-item-info money">
                            <i class="fas fa-coins" title="Cena"></i>
                            <span>{{$offer->price}}{{$offer->currency->short}}</span>
                        </div>
                        <div class="col-md-6 offer-item-info time">
                            <i class="fas fa-clock" title="Otevřeno do"></i>
                            <span><span id="timeleft"></span></span>
                        </div>
                    </div>
                    <!--<div class="d-flex justify-content-between align-items-center">
                        <i class="fas fa-angle-left"></i>
                        <div class="col-md-10 review_box d-flex flex-wrap justify-content-end">
                            <p class="w-100">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet consequatur
                            </p>
                            <span>- <a href="#">Uživatel</a></span>
                        </div>
                        <i class="fas fa-angle-right"></i>
                    </div>!-->
                </div>
            </div>
            <div class="col-md-8">
                <div class="col-12 white_box m-top d-flex justify-content-between align-items-center">
                    <span class="offer_head">{{$offer->name}}</span>
                    <span><b>{{$offer->price}}{{$offer->currency->short}}</b> </span>
                </div>
                <div class="col-12 white_box m-top">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="https://www.stoplusjednicka.cz/sites/default/files/styles/full/public/obrazky/2019/03/22_01_panda.jpg?itok=zLpPRNsW" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="https://www.stoplusjednicka.cz/sites/default/files/styles/full/public/obrazky/2019/03/22_01_panda.jpg?itok=zLpPRNsW" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="https://www.stoplusjednicka.cz/sites/default/files/styles/full/public/obrazky/2019/03/22_01_panda.jpg?itok=zLpPRNsW" class="d-block w-100" alt="...">
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Předchozí</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Další</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row box m-top">
            <div class="white_box w-100 m-15">
                <h4 style="margin-left:5px;">Informace</h4>
                <div>
                    <div class="tags">
                        @foreach($offer->tags as $t)
                        <div class="tag">{{$t->name}}</div>
                        @endforeach
                    </div>
                </div>
                <p>{{$offer->description}}</p>
            </div>
        </div>
    </div>
@stop
@section('scripts')
    <script src="{{URL::asset("/assets/js/custom/offer/Timer.js")}}"></script>
    <script>
        @if(\Carbon\Carbon::now()->diffInHours($timestamp,false) <= 48)
        var timer = new Timer({{$timestamp->timestamp*1000}},"timeleft");
        timer.start()
        @endif
    </script>
@stop
