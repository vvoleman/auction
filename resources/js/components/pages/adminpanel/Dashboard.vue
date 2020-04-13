<template>
    <div class="col-md-10 mx-auto m-top2">
        <div>
            <div class="d-md-flex">
                <h5 class="disabled description">Statistiky</h5>
            </div>
            <div>
                <transition name="fade" mode="out-in">
                    <loader v-if="loading.bits && !error.bits"></loader>
                    <div v-if="!loading.bits && !error.bits" key="data" class="blocks m-top-50 d-md-flex justify-content-around">
                        <div class="block col-md-2" :class="bits_class[i]" v-for="(o,i) in bits">
                            <h2>{{o.value}}</h2>
                            <p>{{o.label}}</p>
                        </div>
                    </div>
                    <div v-if="error.bits" key="error" class="alert alert-danger">
                        <b>Pozor! </b>Nelze načíst
                    </div>
                </transition>
            </div>
            <div class="" style="margin-top:80px;">
                <div class="d-md-flex">
                    <h5 class="disabled description">Grafy</h5>
                </div>
                <div>
                    <div class="d-md-flex justify-content-end align-items-baseline">
                        <select class="col-md-1 form-control">
                            <option v-for="(o,i) in years_for">{{o}}</option>
                        </select>
                        <select v-model="selected.graphs_by_year" class="form-control col-md-2">
                            <option :value="i" v-for="(o,i) in byYearNames" :key="i">{{o}}</option>
                        </select>
                    </div>

                    <bar-graph class="" :labels="selected_gby.labels" :datasets="selected_gby.datasets"></bar-graph>
                </div>

            </div>
            <div>
                <pie-graph :datasets="categories.datasets" :labels="categories.labels" class="col-3"></pie-graph>
            </div>
        </div>
    </div>
</template>

<script>
    import BarGraph from "../../sub/BarGraph";
    import PieGraph from "../../sub/PieGraph";
    import Loader from "../../sub/Loader";
    export default {
        name: "Dashboard",
        components: {Loader, PieGraph, BarGraph},
        data(){
            return {
                error:{
                    bits:false,
                    byYear:false,
                    categories:false,
                },
                loading:{
                    bits:false,
                    byYear:false,
                    categories:false
                },
                bits:[],
                bits_class:["green","blue","orange","red"],
                byYear:[

                ],
                selected:{
                    graphs_by_year:0
                },
                categoriesPie:null
            }
        },
        mounted(){
            this.getBits();
            this.getByYear();
            this.getPercentage();
        },
        methods:{
            getBits(){
                this.loading.bits = true;
                axios.get("/ajax/admin/getBits")
                    .then(response=>{
                        this.bits = response.data;
                        this.loading.bits = false;
                        this.error.bits = false;
                    })
                    .catch(err=>{
                        this.error.bits = true;
                    });
            },
            getByYear(){
                this.loading.byYear = true;
                axios.get("/ajax/admin/getByYear")
                    .then(response=>{
                        this.byYear = response.data;
                        this.loading.byYear = false;
                        this.error.byYear = false;
                    })
                    .catch(err=>{
                        this.error.byYear = true;
                    });
            },
            getPercentage(){
                this.loading.categories = true;
                axios.get("/ajax/admin/getCategoryPercentage")
                    .then(response=>{
                        this.categoriesPie = response.data;
                        this.loading.categories = false;
                        this.error.categories = false;
                    })
                    .catch(err=>{
                        this.error.categories = true;
                    });
            }
        },
        computed:{
            selected_gby(){
                var temp = this.byYear[this.selected.graphs_by_year];
                if(temp == null){
                    return {labels:[],datasets:[]};
                }
                var curr = temp[temp.length-1];
                console.log(curr.graph);
                return curr.graph;
            },
            years_for(){
                var temp = this.byYear[this.selected.graphs_by_year];
                if(temp == null){
                    return [];
                }
                var years = [];
                temp.forEach(x=>{
                    years.push(x.year);
                })
                return years;
            },
            categories(){
                if(this.categoriesPie == null){
                    return {labels:[],datasets:{}};
                }
                return this.categoriesPie;
            },
            byYearNames(){
                var names = [];
                this.byYear.forEach(x=>{
                   names.push(x[0].graph.name);
                });
                return names;
            }
        }
    }
</script>

<style scoped>
    .description{
        font-family:Raleway;
        text-transform:uppercase;
        color:#ccc;
    }
</style>
