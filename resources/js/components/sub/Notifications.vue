<template>
    <div @click="open" class="picture-nav d-flex align-items-end justify-content-end"
         :style="{'background-image':'url('+url+')'}">
        <transition name="zoom">
            <div v-if="badge_number!=0" class="not-circle">{{badge_number}}</div>
        </transition>
        <transition name="zoom">
            <div v-cloak class="not-bar col-rl-3 col-lg-4" v-if="show" v-on-click-outside="close" @click.stop="">
                <div v-for="(o,i) in nots" class="">
                    <a :href="o.url">
                    <div class="item d-flex align-items-center justify-content-between">
                        <div class="d-none d-md-flex big-circle">
                            <i :class="o.icon"></i>
                        </div>
                        <div class="offset-md-3">

                            <a></a><span class="title">{{o.title}}</span>
                            <div class="w-100 date d-flex justify-content-between align-items-center">
                                <span class="d-block">{{o.time}}</span>
                                <i class="fas" :class="{'fa-eye-slash':!o.seen,'fa-eye':o.seen}" @click.stop="toggleSeen(i)"></i>
                            </div>
                        </div>
                    </div>
                    </a>
                    <hr v-if="nots.length-1 > i">
                </div>
                <div v-if="nots.length == 0" class="empty">
                    <span>Žádné notifikace</span>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
    import {mixin as onClickOutside} from 'vue-on-click-outside'

    export default {
        mixins: [onClickOutside],
        name: "Notifications",
        props: ['url','notifications'],
        mounted(){
            this.nots = JSON.parse(this.notifications);
        },
        data() {
            return {
                show: false,
                nots: []
            }
        },
        methods: {
            close() {
                this.show = false;
            },
            open() {
                this.show = true;
                this.nots = this.nots.map((x) => {
                    if (!x.seen){
                        x.seen = true;
                        this.updateSeen(x);
                    }
                    return x;
                });
            },
            toggleSeen(i){
                this.nots[i].seen = !this.nots[i].seen;
                this.updateSeen(this.nots[i])
            },
            updateSeen(not){
                axios.post('/ajax/notifications/seen',{seen:not.seen,not_id:not.not_id})
                    .then((response)=>{
                    })
                    .catch((error)=>{
                       console.log(error);
                    });
            }
        },
        computed: {
            badge_number() {
                var number = this.not_seen.length;
                return (number > 9) ? "9+" : number;
            },
            not_seen() {
                return this.nots.filter((x) => {
                    return !x.seen;
                });
            }
        }
    }
</script>

<style scoped>
    .empty{
        padding:10px;
        text-align: center;
        color:#838383;
    }

    hr {
        margin: 0;
    }

    * {
        user-select: none;
    }

    .not-bar {
        padding-left: 0;
        padding-right: 0;
        user-select: none;
        z-index: 10;
        margin-top: 80px;
        top: 0;
        position: absolute;
        background: #fafafa;
        border: 1px solid #dadada;
        color: white;
        right: 0;

    }

    .item {
        padding: 5px 15px 5px 15px;
    }

    .item:hover {
        background: #d1d1d1;
    }

    .item .title {
        color: black;
        font-weight: 23px;
        font-weight: bold;
    }

    .item .date {
        font-size: 16px;
        color: #868686;
    }

    .big-circle {
        position: absolute;
        border-radius: 100%;
        width: 40px;
        height: 40px;
        font-size: 15px;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #1b1e21;
        color: white;
    }
</style>
