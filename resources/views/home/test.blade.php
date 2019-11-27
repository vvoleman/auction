@extends('mains.main')
@section('title',"")
@section('content')
    <div class="m-top">
        <div class="head col-md-6 justify-content-center mx-auto d-flex align-items-center">
            <img src="https://www.knihydobrovsky.cz/files/thumbs/mod_eshop/produkty/c/cilcina-cesta-9788026428138.280299474.1574387850.jpg">
            <div class="m-left">
                <h2>Cilčina cesta</h2>
                <span><b>Autoři:</b></span>
                <div class="m-left">
                    <span class="d-block">Heather Morrisová</span>
                    <span class="d-block">Heather Morrisová</span>
                </div>
                <div class="d-flex align-items-center stars">
                    <span>5</span>
                    <i class="fas fa-star text-danger" style="margin-left: 3px;"></i>
                </div>
                <div class="m-top">
                    <span><b>Žánry:</b></span>
                    <div class="m-left">
                        <span class="d-block">Beletrie</span>
                        <span class="d-block">Poezie</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 m-top mx-auto">
            <div class="subnav d-flex">
                <a onclick="openDiv(event,0)" class="selected">Popis</a>
                <a onclick="openDiv(event,1)">Hodnocení</a>
                <a onclick="openDiv(event,2)">V sérii</a>
            </div>
            <div class="head">
                <div id="popis" class="sub_item active">
                    <h3>Popis</h3>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                        the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley
                        of type and scrambled it to make a type specimen book. It has survived not only five centuries
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                        the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley
                        of type and scrambled it to make a type specimen book. It has survived not only five centuries
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                        the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley
                        of type and scrambled it to make a type specimen book. It has survived not only five centuries
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                        the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley
                        of type and scrambled it to make a type specimen book. It has survived not only five centuries
                    </p>
                </div>
                <div id="hodnoceni" class="sub_item">
                    <h3>Hodnocení</h3>
                </div>
                <div id="serie" class="sub_item">
                    <h3>V sérii</h3>
                </div>
            </div>
        </div>
    </div>
@stop
@section('scripts')
    <script>
        reload();

        function openDiv(e, i) {
            $(".subnav a").removeClass("selected");
            $(e.target).addClass("selected");
            $(".sub_item.active").removeClass("active");
            $(".sub_item").eq(i).addClass("active");
            reload();
        }

        function reload() {
            $(".sub_item.active").show();
            $(".sub_item:not(.active)").hide();
        }
    </script>
@stop
