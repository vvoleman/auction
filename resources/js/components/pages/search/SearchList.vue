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
                    <!--<div class="col-md-11 mx-auto d-flex justify-content-between align-items-center">
                        <div>
                            <img src="https://atasouthport.com/wp-content/uploads/2017/04/default-image-800x600.jpg"
                                 height="100px;">
                        </div>
                        <div>
                            <h5>{{o.name}}</h5>
                        </div>
                        <div class="col-md-5 d-flex justify-content-between">
                            <div>
                                <div class="money">
                                    <i class="fas fa-coins" title="Cena"></i>
                                    <span>{{o.price}} {{o.currency}}</span>
                                </div>
                                <div class="time">
                                    <i class="fas fa-clock" title="Otevřeno do"></i>
                                    <span>{{o.end_date}}</span>
                                </div>
                            </div>
                            <div>
                                <div>
                                    <a :href="o.owner.url">{{o.owner.name}}</a>
                                </div>
                                <div>
                                    <span>{{o.owner.score}}</span>
                                    <i class="fas fa-star text-danger"></i>
                                </div>
                            </div>
                        </div>
                    </div>!-->
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
