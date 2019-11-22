<template>
    <div class="col-md-8 mx-auto m-top3">
        <div v-if="urls.length != 0" class="white_box">
            <input type="search" class="form-control" placeholder="Vyhledej...">
            <filterbox @changed="filterChanged" :boot="boot" class="subbox col-md-11 m-top mx-auto"></filterbox>
            <i class="fas fa-chevron-down w-100 text-center m-top" style="margin-bottom: 0px"></i>
        </div>
        <searchlist v-if="results.length != 0" :results="results"></searchlist>
        <div class="white_box m-top text-center">
            Žádné výsledky
        </div>
    </div>
</template>

<script>
    import filterbox from "./sub/FilterBox";
    import searchlist from "./sub/SearchList";
    export default {
        name: "search-page",
        components: {filterbox,searchlist},
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
                urls:[],
                results:[
                ],
                nextPage:false
            }
        },
        mounted(){
            this.urls = JSON.parse(this.url);
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
                    this.results = response.data.data;
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
