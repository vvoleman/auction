<template>
    <div class="col-md-8 mx-auto" v-if="data != null">
        <div class="row align-items-start">
            <div class="col-md-4 d-flex flex-wrap flex-column justify-content-between">
                <div class="col-12 white_box m-top test_offer">
                    <div class="row justify-content-end" style="margin-right:5px" v-if="data.is_owner">
                        <a :href="data.edit_url" class="fas fa-cog text-muted"></a>
                    </div>
                    <img :src="data.owner.profpic_path" class="img_bubble mx-auto d-block" width="100px">
                    <h5 class="m-top text-center">{{data.owner.fullname}}</h5>
                    <div class="d-flex justify-content-center align-items-center"><img
                            :src="data.country_img" class="flag-sm" style="margin-right: 5px;">{{data.region}}
                    </div>
                    <hr>
                    <div class="text-center">
                        <span class="offer_info"><b>15</b> nabídek</span>
                        <span><b>4,7</b> <i class="fas fa-star text-danger"></i></span>
                    </div>
                </div>
                <div class="col-12 white_box m-top test_offer">
                    <h5 class="text-center">Základní informace</h5>
                    <hr>
                    <div class="col-12 d-flex flex-wrap mx-auto">
                        <div class="col-md-6 offer-item-info delivery">
                            <i class="fas fa-truck" title="Doprava"></i>
                            <span>{{data.delivery}}</span>
                        </div>
                        <div class="col-md-6 offer-item-info payment">
                            <i class="far fa-money-bill-alt" title="Platba"></i>
                            <span>{{data.payment}}</span>
                        </div>
                        <div class="col-md-6 offer-item-info money">
                            <i class="fas fa-coins" title="Cena"></i>
                            <span>{{data.price}}{{data.currency}}</span>
                        </div>
                        <div class="col-md-6 offer-item-info time">
                            <i class="fas fa-clock" title="Otevřeno do"></i>
                            <span :title="data.end_date.format"><span id="timeleft">{{data.end_date.format}}</span></span>
                        </div>
                    </div>
                </div>
                <button class="btn btn-block btn-blue m-top" style="padding:30px;" @click="openBuyModal">Zakoupit</button>
                <modal v-if="buy_modal">
                    <div slot="header">Zakoupit předmět</div>
                    <div slot="body">
                        <p><b>Jak to funguje?</b></p>
                        <p>Nejdříve zašleme Vaší žádost k potvrzení autorovi nabídky.</p>
                    </div>
                    <div slot="footer"><button class="btn btn-danger" @click="closeBuyModal">Zavřít</button></div>
                </modal>
            </div>
            <div class="col-md-8">
                <div class="col-12 white_box m-top d-flex justify-content-between align-items-center">
                    <span class="offer_head">{{data.name}}</span>
                    <span><b>{{data.price}}{{data.currency}}</b> </span>
                </div>
                <div class="col-12 white_box m-top">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="https://www.stoplusjednicka.cz/sites/default/files/styles/full/public/obrazky/2019/03/22_01_panda.jpg?itok=zLpPRNsW"
                                     class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="https://www.stoplusjednicka.cz/sites/default/files/styles/full/public/obrazky/2019/03/22_01_panda.jpg?itok=zLpPRNsW"
                                     class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="https://www.stoplusjednicka.cz/sites/default/files/styles/full/public/obrazky/2019/03/22_01_panda.jpg?itok=zLpPRNsW"
                                     class="d-block w-100" alt="...">
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                           data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Předchozí</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                           data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Další</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row box m-top">
            <div class="white_box w-100 m-15">
                <h4 style="margin-left:5px;">Informace</h4>
                <div>
                    <div class="tags">
                        <div class="tag" v-for="o in data.tags">{{o}}</div>
                    </div>
                </div>
                <p v-html="data.description"></p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "show-selloffer",
        props: ["o_data"],
        data() {
            return {
                data: null,
                buy_modal:false
            };
        },
        mounted() {
            this.data = JSON.parse(this.o_data);
        },
        methods:{
            openBuyModal(){
                this.buy_modal = true;
            },
            closeBuyModal(){
                this.buy_modal = false;
            }
        }
    }
</script>

<style scoped>

</style>
