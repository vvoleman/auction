<template>
    <div>
        <div class="col-12 d-flex justify-content-end align-items-center changeview">
            <i class="fas fa-th" :class="{'grid-select':grid}" @click="grid = true"></i>
            <i class="fas fa-th-list" style="margin-left:10px" :class="{'grid-select':!grid}" @click="grid = false"></i>
        </div>
        <div class="d-md-flex flex-wrap">
            <div class="m-top search-item" v-for="(o,i) in offers" :class="{'col-md-4':grid,'col-12':!grid}">
                <a :href="o.url" class="no-a">
                    <div class="status_bar" :class="o.status">{{getStatus(o.status)}}</div>
                    <div class="white_box">
                        <div class="d-md-flex align-items-center flex-wrap">
                            <img class="col-rl-5"
                                 src="https://ae01.alicdn.com/kf/HTB1X9GBvuuSBuNjy1Xcq6AYjFXay/1PCS-New-24-Pages-Mandalas-Flower-Coloring-Book-For-Children-Adult-Relieve-Stress-Kill-Time-Graffiti.jpg_220x220xz.jpg.webp">
                            <div class="col-rl-8" style="margin-left:5px;">
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
                </a>
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
        <button :disabled="block" class="btn btn-block btn-blue m-top" v-if="page != false" @click="more">Načíst další
        </button>
    </div>
</template>

<script>
    export default {
        name: "OffersList",
        props: ["ofs", "page"],
        data() {
            return {
                offers: this.ofs,
                block: false,
                next: this.page,
                grid: true
            }
        },
        methods: {
            more() {
                this.block = true;
                this.$emit("more");
            },
            formatDate(timestamp) {
                var d = new Date(timestamp * 1000);
                return d.toLocaleDateString() + " " + d.toLocaleTimeString();
            },
            getStatus(status) {
                switch (status) {
                    case "active":
                        return "Aktivní";
                    case "deleted":
                        return "Smazáno";
                    case "expired":
                        return "Vypršelo";
                    case "sold":
                        return "Prodáno";
                    default:
                        return "";
                }
            },
            canLink(type) {
                return type == "active" || type == "expired";
            }
        },
        watch: {
            ofs() {
                this.block = false;
                this.offers = this.ofs;
            },
            page() {
                this.next = this.page;
            }
        }
    }
</script>

<style scoped>
    .status_bar {
        text-align: center;
        font-weight: bold;
    }

    .active {
        background-color: #1ED761;
    }

    .deleted {
        background-color: #ed2939;
    }

    .expired {
        background-color: #F8E816;
    }

    .sold {
        background-color: #7a7a7a;
    }

    .white_box {
        box-shadow: 0px 6px 10px 0px rgba(224, 224, 224, 1);
        border-radius: 0px 0px 5px 5px;
    }

    .grid-select {
        background: #eeeeee !important;
    }

    .changeview i {
        background: white;
        border-radius: 100%;
        width: 40px;
        height: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0px 0px 10px 0px rgba(214, 214, 214, 1);
        transition: 0.1s;
        cursor: pointer;
    }

    .changeview i:not(.grid-select):hover {
        background: #f5f5f5;
    }
</style>
