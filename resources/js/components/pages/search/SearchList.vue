<template>
    <div>
        <div v-if="results != null" class="col-md-12">
            <div class="white_box m-top search-item" v-for="(o,i) in results">
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
                                <tr>
                                    <td>
                                        <div class="small"
                                             :style="{'background-image':`url('${o.owner.picture}')`}"></div>
                                    </td>
                                    <td><a :href="o.owner.url"><span>{{o.owner.name}}</span></a></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><i class="fas fa-star text-danger"></i> {{o.owner.score}} / {{o.owner.offers}} {{sklonuj(o.owner.offers)}}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div v-else>
            fff
        </div>
    </div>
</template>
<script>
    export default {
        name: "SearchList",
        props: ["results"],
        methods:{
            sklonuj(n){
                var vysl;
                if(n==1){
                    vysl = "nabídka";
                }else if(n>1 && n<5){
                    vysl = "nabídky";
                }else{
                    vysl = "nabídek";
                }
                return vysl;
            }
        }
    }
</script>

<style scoped>
    .right-side {
        margin-left: 15px;
    }

    .info-side li {
        list-style-type: none;
    }
</style>
