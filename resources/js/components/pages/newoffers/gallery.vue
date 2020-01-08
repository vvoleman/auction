<template>
    <div>
        <div>
            <img v-for="(o,i) in files" :src="o" class="col-6" @click="remove(i)">
        </div>
    </div>
</template>

<script>
    import VueEasyLightbox from 'vue-easy-lightbox'
    export default {
        name: "gallery",
        props:{
            files:{
                default: ()=>{return []}
            }
        },
        components:{VueEasyLightbox},
        data(){
            return {
                visible:false,
                imgs:[]
            }
        },
        mounted(){
            this.filesToImgs();
        },
        methods:{
            remove(i){
                this.$emit("remove",i);
            },
            filesToImgs(){
                this.imgs = this.files.map((x)=>{
                    return x
                });
            }
        },
        watch:{
            files(){
                this.filesToImgs();
            }
        }
    }
</script>

<style scoped>
    img{
    }
</style>
