<template>
    <div>

        <slot name="test"></slot>
        <div class="white_box m-top3 text-center">
            <h3>Zájem o "{{offer.name}}"</h3>
        </div>
        <div class="white_box m-top">
            <h4>Zájemce</h4>
            <table class="col-md-10 mx-auto table m-top2">
                <thead>
                <tr>
                    <td>Jméno</td>
                    <td>Adresa</td>
                    <td>Hodnocení</td>
                </tr>
                </thead>

                <tbody>
                <tr>
                    <td>{{customer.fullname}}</td>
                    <td>{{customer.address}}</td>
                    <td>4,7 <i class="fas fa-star text-danger"></i></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="white_box m-top">
            <h4>Produkt</h4>
            <table class="col-md-10 mx-auto table m-top2">
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
                    <td>{{offer.name}}</td>
                    <td>{{offer.price}}</td>
                    <td>{{offer.delivery}}</td>
                    <td>{{offer.payment}}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="white_box m-top">
            <h4>Mapa</h4>
            <div id="m" style="height:400px;background:#f0f0f0" class="d-flex justify-content-center align-items-center">
                <span>Zde by se měla nacházet mapa :)</span>
            </div>
        </div>
        <div class="white_box m-top m-bottom">
            <div class="col-md-6 mx-auto d-flex">
                <button class="btn btn-danger col-md-6">Zamítnout</button>
                <button class="btn btn-success col-md-6">Potvrdit</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "confirm-offer",
        props: [],
        data() {
            return {
                customer: {
                    fullname: "Vojtěch Voleman",
                    address: "Random ulice, 40001 Ústí nad Labem"//"Plynárenská 10, 40010 Ústí nad Labem"
                },
                offer: {
                    name:"Koště Nymbus 2000",
                    price: "150 CZK",
                    delivery: "Osobně",
                    payment: "Osobně"
                }
            }
        },
        mounted(){
        },
        methods:{
            loadMap(){
                var obrazek = "https://api.mapy.cz/img/api/marker/drop-red.png";
                var m = new test.SMap(JAK.gel("m"));
                m.addControl(new SMap.Control.Sync());
                m.addDefaultLayer(SMap.DEF_BASE).enable(); /* Turistický podklad */
                var mouse = new SMap.Control.Mouse(SMap.MOUSE_PAN | SMap.MOUSE_WHEEL | SMap.MOUSE_ZOOM); /* Ovládání myší */
                m.addControl(mouse);
                var adr1 = "Kollárova 226/2, 40003 Ústí nad Labem";
                var adr2 = "Plynárenská 10, 40010 Ústí nad Labem";

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
                    this.vykresliBody(body);
                });
            },
            vykresliBody(body) {
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
        }
    }
</script>

<style scoped>

</style>
