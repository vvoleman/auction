@extends('mains.main')
@section('title','')
@section('content')
    <div class="col-md-6 mx-auto">
        <div class="white_box m-top3 text-center">
            <h3>Zájem o "{{$os->offer->name}}"</h3>
        </div>
        <hr>
        <div class="white_box m-top">
            <h4>Zájemce</h4>
            <table class="col-md-10 mx-auto table m-top2 bold_heh">
                <thead>
                <tr>
                    <td>Jméno</td>
                    <td>Adresa</td>
                    <td>Hodnocení</td>
                </tr>
                </thead>

                <tbody>
                <tr>
                    <td>{{$os->name}}</td>
                    <td>{{$os->address}}</td>
                    <td>{{$os->buyer->review_score()}} <i class="fas fa-star text-danger"></i></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="white_box m-top">
            <h4>Produkt</h4>
            <table class="col-md-10 mx-auto table m-top2 bold_heh">
                <thead>
                <tr>
                    <td>Název</td>
                    <td>Cena</td>
                    <td>Doprava</td>
                    <td>Platba</td>
                </tr>
                </thead>

                <tbody>
                <tr>
                    <td>{{$os->offer->name}}</td>
                    <td>{{$os->offer->price}}</td>
                    <td>{{$os->offer->delivery_type->label}}</td>
                    <td>{{$os->offer->payment_type->label}}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="white_box m-top">
            <h4>Mapa</h4>
            <div id="m" style="height:400px"></div>
        </div>
        <div class="white_box m-top m-bottom">
            <div class="mx-auto d-flex justify-content-center">
                <!--<form> method="post" action="{{route('offers.confirm.deny',["id"=>$os->offer->uuid,"os_id"=>$os->id_os])}}"

                    @csrf
                    <button class="btn btn-danger btn-block">Zamítnout</button>
                </form>!-->
                <form method="post" action="{{route('offers.confirm.confirm',["id"=>$os->offer->uuid,"os_id"=>$os->id_os])}}">
                    @csrf
                    <button class="btn btn-success btn-block">Potvrdit</button>
                </form>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script src="https://api.mapy.cz/loader.js"></script>
    <script>Loader.load()</script>
    <script type="text/javascript">
        var obrazek = "https://api.mapy.cz/img/api/marker/drop-red.png";
        var m = new SMap(JAK.gel("m"));
        m.addControl(new SMap.Control.Sync());
        m.addDefaultLayer(SMap.DEF_BASE).enable(); /* Turistický podklad */
        var mouse = new SMap.Control.Mouse(SMap.MOUSE_PAN | SMap.MOUSE_WHEEL | SMap.MOUSE_ZOOM); /* Ovládání myší */
        m.addControl(mouse);
        var adr1 = "{{$os->address}}";
        var adr2 = "{{Auth::user()->fulladdress}}";

        new SMap.Geocoder([adr1,adr2],(data)=>{
            var body = [];
            var results = data.getResults();
            for(var i=0;i<results.length;i++){
                if(results[i].results.length == 0){
                    console.log("Neplatná adresa!");
                }else{
                    body.push(results[i].results[0].coords);
                }
            }
            vykresliBody(body);
        });
        function vykresliBody(body) {
            var znacky = [];
            console.log(body);
            znacky.push(new SMap.Marker(body[0],null,{title:"Zákazník"}));
            znacky.push(new SMap.Marker(body[1],null,{title:"Vy"}));
            //console.log(znacky);

            var layer = new SMap.Layer.Marker();     /* Vrstva se značkami */
            console.log(m);
            m.addLayer(layer);
            layer.enable();
            for(var i=0;i<znacky.length;i++){
                layer.addMarker(znacky[i]);
            }
            var cz = m.computeCenterZoom(body)
            m.setCenterZoom(cz[0], cz[1]);
        }
    </script>
@stop

