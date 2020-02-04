<template>
    <div class="col-md-10 col-rl-8 mx-auto m-top3">
        <div v-if="urls.length != 0" class="white_box" id="content">
            <input type="search" class="form-control" placeholder="Vyhledej..." v-model="query">
            <filterbox v-show="show_control" :class="{'d-flex':show_control}" @changed="filterChanged" :boot="boot"
                           class="subbox col-md-11 m-top mx-auto"></filterbox>
            <i @click="show_control = !show_control"
               :class="{'fa-chevron-down':!show_control,'fa-chevron-up':show_control}"
               class="fas w-100 text-center m-top" style="margin-bottom: 0px;cursor:pointer"></i>
        </div>
        <transition name="fade" mode="out-in">
            <div key="results" v-if="loading == false && error == false && results != null">
                <div v-if="results.length != 0">
                    <searchlist :results="results"></searchlist>
                    <button @click="loadNextPage" v-if="nextPage" class="shadow btn col-12 btn-blue m-top"
                            style="padding:10px;">Načíst další
                    </button>
                </div>
                <div v-else class="white_box m-top text-center">
                    <span v-if="query != 'smysl života'">Žádné výsledky</span>
                    <span v-else>¯\_(ツ)_/¯ </span>
                </div>
            </div>
            <div key="load" v-if="loading == true && error == false" class="loading white_box m-top">
                <div class="lds-facebook">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
            <div key="error" v-if="error == true" class="searcherror m-top">
                <h4>Nebylo možné načíst data!</h4>
            </div>
        </transition>
        <go-up el_id="content"></go-up>
    </div>
</template>

<script>
    import filterbox from "./FilterBox";
    import searchlist from "./SearchList";
    import GoUp from "../../sub/GoUp";

    export default {
        name: "search-page",
        components: {GoUp, filterbox, searchlist},
        props: {
            url: {
                required: true
            },
            boot: {
                required: true
            },
            q: {}
        },
        data() {
            return {
                loading: false,
                error: false,
                page: 0,
                urls: [],
                results: null,
                nextPage: false,
                settings: null,
                first: true,
                query: this.q,
                show_control: false
            }
        },
        mounted() {
            this.urls = JSON.parse(this.url);
            this.loading = true;
        },
        methods: {
            _runBoot() {
                $.get(this.urls.boot, (response) => {
                    console.log(response);
                });
            },
            filterChanged(data, load = true) {
                if (load) this.page = 0;
                data.query = this.query;
                data.order_by = "name" //name,reviews,expiration,price
                data.dir = 1;
                data.page = this.page;
                this.settings = data;
                if (load) this.loading = true;
                axios.get(this.urls.offers, {
                    params: data
                }).then((response) => {
                    if (!load) {
                        this.results = this.results.concat(response.data.data);
                    } else {
                        this.results = response.data.data;
                    }
                    this.nextPage = response.data.next_page != false;
                    this.page = response.data.next_page;
                    this.loading = false;
                }).catch((response) => {
                    this.loading = false;
                    this.error = "Nastala chyba!";
                });
            },
            loadNextPage() {
                this.filterChanged(this.settings, false);
            }
        },
        watch: {
            query: _.debounce(function () {
                this.filterChanged(this.settings);
            }, 300)
        }
    }
</script>

<style scoped>
    .subbox {
        background: #f4f4f4; /*#bfb7b0;*/
    }
</style>
