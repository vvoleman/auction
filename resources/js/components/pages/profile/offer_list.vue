<template>
    <div class="m-top2 d-flex flex-wrap" v-cloak>
        <div class="col-12 d-flex justify-content-end flex-wrap">
            <div class="m-top search-item col-md-12" v-for="(o,i) in offers" v-if="offers!=null && offers.length > 0">
                <div class="col-md-8 mx-auto white_box ">
                    <a :href="o.url" class="no-a">
                        <div class="col-12 mx-auto d-flex justify-content-between">
                            <div class="shadow item-img mx-auto col-md-5"
                                 :style="{'background-image': 'url('+o.picture+')'}">
                            </div>
                            <div class="right-side col-md-5">
                                <h5 class="m-top">{{o.name}}</h5>
                                <div class="m-top2">
                                    <table>
                                        <tr>
                                            <td><i class="fas fa-coins" title="Cena"></i></td>
                                            <td><span>{{o.currency}} {{o.price}}</span></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fas fa-clock" title="Otevřeno do"></i></td>
                                            <td><span>do {{getDate(o.end_date)}}</span></td>
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
                        </div>
                    </a>
                </div>
            </div>

        </div>
        <button v-if="false" class="btn btn-blue m-top2 btn-block" disabled title="Bohužel jsem líný a nestihl jsem to dodělat">
            Načíst další
        </button>
        <div v-if="offers==null || offers.length == 0" class="text-center white_box mx-auto">
            Žádná data
        </div>
        <go-up el_id="start"></go-up>
    </div>
</template>

<script>
    import GoUp from "../../sub/GoUp";

    export default {
        name: "offer_list",
        components: {GoUp},
        props: ['dat'],
        data() {
            return {
                badges: [['Aktivní', true], ['Prodané', true]],
                offers: []
            }
        },
        methods: {
            toggleBadge(i) {
                this.$set(this.badges[i], 1, !this.badges[i][1]);
            },
            getDate(timestamp){
                return new Date(timestamp*1000).toLocaleDateString();
            }
        },
        mounted() {
            this.offers = JSON.parse(this.dat);
        }
    }
</script>

<style scoped>
    .badge-filter {
        text-align: center;
        background: var(--main-blue);
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 16px;
        max-width: 80px;
        margin-left: 5px;
        box-shadow: 0px 0px 10px 0px rgba(214, 214, 214, 1);
        transition: 0.1s;
        cursor: pointer;
        user-select: none;
    }

    .filter-active {
        background: var(--main-orange);
    }

    .badge-filter:not(.filter-active):hover {
        background: var(--main-purple);
    }

    .off_ img {
        width: 100px;
        height: 100px;
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
    }
</style>
