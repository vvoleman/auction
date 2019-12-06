<template>
    <div class="col-md-8 mx-auto">
        <navbar class="" @change="filtersChanged"></navbar>
        <div class="m-top">
        <transition name="fade" mode="out-in">
            <loader key="load" v-if="load && !error"></loader>
            <div key="error" class="alert alert-danger" v-if="error">
                <b>POZOR!</b> Nelze načíst data!
            </div>
            <offers-list key="content" class="" v-if="offers != null && !load && !error" :ofs="offers" :page="page" @more="loadData"></offers-list>
        </transition>
        </div>
    </div>
</template>

<script>
    import Navbar from "./Navbar";
    import OffersList from "./OffersList";
    import Loader from "../../sub/Loader";
    export default {
        name: "show-myoffers",
        components: {Loader, OffersList, Navbar},
        data(){
            return {
                sort:null,
                filter:null,
                page:0,
                dir:null,
                offers:null,
                load:false,
                error:false
            }
        },
        methods:{
            filtersChanged(data){
                this.page = 0;
                this.sort = data.sort;
                this.filter = data.filter;
                this.dir = data.dir;
                this.loadData()
            },
            loadData(){
                this.load = true;
                axios.get("/ajax/myoffers",{params:{
                    order_by:this.sort,
                    filter:this.filter,
                    page:this.page,
                    dir:this.dir
                }})
                    .then((response)=>{
                        this.offers = response.data.data;
                        this.page = response.data.next_page == null;
                    })
                    .catch((e)=>{
                        this.error = true;
                    })
                    .then(()=>{
                        this.load = false;
                    });
            }
        }
    }
</script>

<style scoped>

</style>
