<template>
    <div>
        <div class="d-md-flex flex-wrap">
            <div class="col-md-4 m-top search-item" v-for="(o,i) in offers">
                <div class="white_box col-12"  :class="o.status">
                    <div class="d-md-flex">
                        <img class="col-md-5" src="https://ae01.alicdn.com/kf/HTB1X9GBvuuSBuNjy1Xcq6AYjFXay/1PCS-New-24-Pages-Mandalas-Flower-Coloring-Book-For-Children-Adult-Relieve-Stress-Kill-Time-Graffiti.jpg_220x220xz.jpg.webp">
                        <div class="col-md-7">
                            <h3>{{o.name}}</h3>
                            <div class="m-top2">
                                <b>Počet nabídek: {{o.offersell_amount}}</b>
                            </div>
                            <table>
                                <tr>
                                    <td><i class="fas fa-coins" title="Cena"></i></td>
                                    <td><span>{{o.currency}} {{o.price}}</span></td>
                                </tr>
                                <tr>
                                    <td><i class="fas fa-clock" title="Otevřeno do"></i></td>
                                    <td><span>do {{formatDate(o.end_date)}}</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                <!--<a :href="o.url" class="no-a">
                    <div class="col-12 mx-auto d-md-flex">
                        <div class="shadow item-img mx-auto"
                             style="background-image: url('https://ae01.alicdn.com/kf/HTB1X9GBvuuSBuNjy1Xcq6AYjFXay/1PCS-New-24-Pages-Mandalas-Flower-Coloring-Book-For-Children-Adult-Relieve-Stress-Kill-Time-Graffiti.jpg_220x220xz.jpg.webp')">
                        </div>
                        <div class="right-side col-md-4">
                            <h3>{{o.name}}</h3>
                            <div class="m-top2">
                                <b>Počet nabídek: {{o.offersell_amount}}</b>
                            </div>
                            <table>
                                <tr>
                                    <td><i class="fas fa-coins" title="Cena"></i></td>
                                    <td><span>{{o.currency}} {{o.price}}</span></td>
                                </tr>
                                <tr>
                                    <td><i class="fas fa-clock" title="Otevřeno do"></i></td>
                                    <td><span>do {{formatDate(o.end_date)}}</span></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-4 info-side mx-auto d-flex justify-content-end">
                            
                        </div>
                    </div>
                </a>!-->
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
            },
            formatDate(timestamp){
                var d = new Date(timestamp*1000);
                return d.toLocaleDateString()+" "+d.toLocaleTimeString();
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
