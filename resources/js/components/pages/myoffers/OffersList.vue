<template>
    <div>
        <div class="white_box m-top search-item" v-for="(o,i) in offers" :class="o.status">
                <a :href="o.url" class="no-a">
                    <div class="col-12 mx-auto d-md-flex">
                        <div class="shadow item-img mx-auto"
                             style="background-image: url('https://ae01.alicdn.com/kf/HTB1X9GBvuuSBuNjy1Xcq6AYjFXay/1PCS-New-24-Pages-Mandalas-Flower-Coloring-Book-For-Children-Adult-Relieve-Stress-Kill-Time-Graffiti.jpg_220x220xz.jpg.webp')">
                        </div>
                        <div class="right-side col-md-4">
                            <b>{{o.name}}</b>
                            <div>
                            </div>
                        </div>
                        <div class="col-md-4 info-side mx-auto d-flex justify-content-end">
                            <table>
                                <tr>
                                    <td><i class="fas fa-coins" title="Cena"></i></td>
                                    <td><span>{{o.currency}} {{o.price}}</span></td>
                                </tr>
                                <tr>
                                    <td><i class="fas fa-clock" title="Otevřeno do"></i></td>
                                    <td><span>do {{o.end_date}}</span></td>
                                </tr>
                                <tr>
                                    <td><i class="fas fa-truck" title="Typ dopravy"></i></td>
                                    <td><span>{{o.delivery}}</span></td>
                                </tr>
                                <tr>
                                    <td><i class="fas fa-credit-card" title="Typ platby"></i></td>
                                    <td><span>{{o.payment}}</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </a>
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
    .active{
        background-color: #90ee90;
    }
    .deleted{
        background-color: #ffcccb;
    }
    .expired{
        background-color: #FFFF66;
    }
</style>
