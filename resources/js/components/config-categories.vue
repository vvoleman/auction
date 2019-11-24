<template>
    <div class="m-top3">
        <transition>
            <categories-shower v-show="is_ready" :c="categories"></categories-shower>
        </transition>
    </div>
</template>

<script>
    import CategoriesShower from "./sub/CategoriesShower";
    export default {
        name: "config-categories",
        components: {CategoriesShower},
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
