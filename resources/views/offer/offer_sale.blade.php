@extends('mains.main')
@section('content')
    <show-selloffer o_data="{{$data}}"></show-selloffer>
    <div id="m" style="height:600px"></div>
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
        var adr1 = "{{$offer->owner->fulladdress}}";
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
            znacky.push(new SMap.Marker(body[0],null,{title:"Prodejce"}));
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
