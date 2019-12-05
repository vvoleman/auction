<template>
    <div>
        <div v-for="(o,i) in offers">
            <h6>{{o.name}}</h6>
        </div>
        <button :disabled="block" class="btn btn-block btn-blue" v-if="page != false" @click="more">Načíst další</button>
    </div>
</template>

<script>
    export default {
        name: "OffersList",
        props:["ofs","page"],
        data(){
            return {
                offers:this.ofs,
                block:false,
                next:this.page
            }
        },
        methods:{
            more(){
                this.block = true;
                this.$emit("more");
            }
        },
        watch:{
            ofs(){
                this.block = false;
                this.offers = this.ofs;
            },
            page(){
                this.next = this.page;
            }
        }
    }
</script>

<style scoped>

</style>
