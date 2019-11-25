<template>
    <div class="m-top3">
        <transition name="fade" mode="out-in">
            <loader v-if="!is_ready" key="load"></loader>
            <categories-shower key="c" v-if="is_ready" :c="categories"></categories-shower>
        </transition>
    </div>
</template>

<script>
    import CategoriesShower from "./CategoriesShower";
    import Loader from "../../sub/Loader";
    export default {
        name: "config-categories",
        components: {Loader, CategoriesShower},
        data(){
            return {
                categories:[],
                modals:{
                    add:false
                }
            }
        },
        mounted(){
            this.getCategories();
        },
        methods:{
            getCategories(){
                axios.get("/ajax/admin/getCategories")
                    .then((response)=>{
                        console.log(response);
                        this.categories = response.data;
                    })
                    .catch((e)=>{
                        console.log(e);
                    });
            },
            colorChange(data){
                console.log(data);
            }
        },
        computed:{
            is_ready(){
                return this.categories.length > 0;
            }
        }
    }
</script>

<style scoped>

</style>
