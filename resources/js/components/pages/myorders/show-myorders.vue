<template>
    <div class="col-md-8 mx-auto m-top3">
        <div>
            <h2 class="text-center">Moje objednávky</h2>
        </div>
        <navbar class="m-top2" @change="filtersChanged" id="toolbar"></navbar>
        <div class="m-top">
        <transition name="fade" mode="out-in">
            <!--<loader key="load" v-if="load && !error"></loader>!-->
            <div key="error" class="alert alert-danger" v-if="error">
                <b>POZOR!</b> Nelze načíst data!
            </div>
            <offers-list key="content" class="" v-if="true" :ofs="offers" :page="page" @more="loadData"></offers-list>
            <!-- offers != null && !load && !error !-->
        </transition>
        </div>
        <go-up el_id="toolbar"></go-up>
    </div>
</template>

<script>
    import Navbar from "./Navbar";
    import OffersList from "./OffersList";
    import Loader from "../../sub/Loader";
    import GoUp from "../../sub/GoUp";
    export default {
        name: "show-myorders",
        components: {GoUp, Loader, OffersList, Navbar},
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
                this.offers = [];
                this.loadData()
            },
            loadData(){
                this.load = true;
                axios.get("/ajax/myorders",{params:{
                    order_by:this.sort,
                    filter:this.filter,
                    page:this.page,
                    dir:this.dir
                }})
                    .then((response)=>{
                        this.offers = this.offers.concat(response.data.data);
                        this.page = (response.data.next_page != null) ? response.data.next_page : false;
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
