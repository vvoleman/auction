<template>
    <div class="col-md-8 mx-auto m-top3">
        <div class="white_box">
            <input type="search" class="form-control" placeholder="Vyhledej...">
            <div class="subbox col-md-11 mx-auto m-top3 d-flex flex-wrap">
                <div class="col-md-4">
                    <label>Cena</label>
                    <slider :max="5000" v-model="controls.price" class="form-control" :tooltip="'focus'"></slider>
                </div>
                <div class="col-md-4 form-group">
                    <label>Typ nabídky</label>
                    <select class="form-control" v-model="controls.selected_type">
                        <option value="null">---</option>
                        <option v-for="(o,i) in controls.types" :value="o.id" :key="i">{{o.name}}</option>
                    </select>
                </div>
                <div class="col-md-4 form-group">
                    <label>Měna</label>
                    <select class="form-control" v-model="controls.selected_currency">
                        <option v-for="(o,i) in controls.currencies" :value="o.id" :key="i">{{o.name}}</option>
                    </select>
                </div>
                <div class="col-md-4 form-group">
                    <label>Země</label>
                    <select class="form-control" v-model="controls.selected_country">
                        <option value="null">---</option>
                        <option v-for="(o,i) in controls.countries" :value="o.id" :key="i">{{o.name}}</option>
                    </select>
                </div>
                <div class="col-md-4 form-group">
                    <label>Kraj</label>
                    <select class="form-control" v-model="controls.selected_region">
                        <option value="null">---</option>
                        <option v-for="(o,i) in controls.regions[controls.selected_country]" :value="o.id" :key="i">{{o.name}}</option>
                    </select>
                </div>
            </div>
            <i class="fas fa-chevron-down w-100 text-center m-top" style="margin-bottom: 0px"></i>
        </div>
    </div>
</template>

<script>
    export default {
        name: "search-page",
        data(){
            return {
                controls:{
                    price:[0,5000],
                    types:[
                        {
                            id:1,
                            name:"Aukce"
                        },
                        {
                            id:2,
                            name:"Prodej"
                        }
                    ],
                    currencies:[
                        {id:1,name:"CZK"},{id:2,name:"EUR"}
                    ],
                    countries:[
                        {id:1,name:"Česká republika"},{id:2,name:"Slovenská republika"}
                    ],
                    regions:{
                        null:[{id:null,name:"---"}],
                        1:[{id:1,name:"Praha"}],
                        2:[{id:1,name:"Bratislava"}]
                    },
                    selected_type:null,
                    selected_currency:1,
                    selected_country:null,
                    selected_region:null,
                }
            }
        }
    }
</script>

<style scoped>
    .subbox{
        background: #f4f4f4; /*#bfb7b0;*/
    }
</style>
