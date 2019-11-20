<template>
    <div class="col-md-8 mx-auto m-top3">
        <div v-if="controls.types.length != 0" class="white_box">
            <input type="search" class="form-control" placeholder="Vyhledej...">
            <filterbox @changed="filterChanged" :boot="boot" class="subbox col-md-11 m-top mx-auto"></filterbox>
            <i class="fas fa-chevron-down w-100 text-center m-top" style="margin-bottom: 0px"></i>
        </div>
    </div>
</template>

<script>
    import filterbox from "./sub/FilterBox";
    export default {
        name: "search-page",
        components: {filterbox},
        props:{
            url:{
                required:true
            },
            boot:{
                required:true
            }
        },
        data(){
            return {
                page:0,
                controls:{
                    price:[],
                    types:[],
                    currencies:[],
                    countries:[],
                    regions:{},
                    selected_type:null,
                    selected_currency:null,
                    selected_country:null,
                    selected_region:null,
                    urls:{}
                }
            }
        },
        mounted(){
            this.urls = JSON.parse(this.url);
            var temp = JSON.parse(this.boot);
            this.controls.price = [parseFloat(temp.min),parseFloat(temp.max)];
            this.controls.types = temp.types;
            this.controls.currencies = temp.currencies;
            this.controls.countries = temp.countries;
            this.controls.regions = temp.regions;
        },
        methods:{
            _runBoot(){
                $.get(this.urls.boot,(response)=>{
                    console.log(response);
                });
            },
            filterChanged(data){
                data.query = "";
                data.order_by = "name" //name,reviews,expiration,price
                data.dir = 1;
                data.page = this.page;
                axios.get(this.urls.offers,{
                    params:data
                }).then((response)=>{
                    console.log(response.data)
                }).catch((response)=>{
                    console.log("Nastala chyba!");
                });
            }
        },

    }
</script>

<style scoped>
    .subbox{
        background: #f4f4f4; /*#bfb7b0;*/
    }
</style>
