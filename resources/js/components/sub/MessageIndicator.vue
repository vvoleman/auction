<template>
    <div class="d-flex align-items-end justify-content-end env" style="margin-right:15px">
        <button @click="open">
        <i class="far fa-envelope"></i>
        </button>
        <transition name="zoom">
            <div v-if="msgs.length!=0" class="not-circle">{{msgs.length}}</div>
        </transition>
        <transition name="zoom">
            <div v-cloak class="not-bar col-rl-3 col-lg-4" v-if="show" v-on-click-outside="close" @click.stop="">
                <div v-for="(o,i) in msgs" class="">
                    <a :href="o.url">
                        <div class="item d-flex align-items-center justify-content-between">
                            <div class="d-none d-md-flex big-circle picture-nav" :style="{'background-image':'url('+o.from.img+')'}">

                            </div>
                            <div class="offset-md-3">

                                <a></a><span class="title">{{o.from.name}}:</span> <span style="color:black"> {{shorten(o.message.message)}}</span>
                                <div class="w-100 date d-flex justify-content-between align-items-center">
                                    <span class="d-block">{{o.message.sent_at}}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                    <hr v-if="msgs.length-1 > i">
                </div>
                <div v-if="msgs.length == 0" class="empty">
                    <span>Žádné nové zprávy</span>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
    require('howler');
    import {mixin as onClickOutside} from 'vue-on-click-outside'

    export default {
        mixins: [onClickOutside],
        name: "MessageIndicator",
        props:{
            y_uuid:{
              type:String,
              required:true
            },
            notify:{
                type:Boolean,
                default:()=>{return true}
            },
            messages:{
                type:Array,
                default:()=>{return []}
            },
            sound:null
        },
        props:["y_uuid","notify","messages"],
        data(){
            return {
                msgs:[],
                show:false
            }
        },
        mounted(){
            this.msgs = JSON.parse(this.messages);

            if((this.notify == "1")){
                this.subscribe();
            }
        },
        methods:{
            subscribe(){
                if(this.sound == null){
                    this.sound = new Howl({
                        src:"/assets/sounds/sound.mp3",
                        volume:1
                    });
                }

                Echo.private(`user.indicator.`+this.y_uuid)
                    .listen('ChangeIndicator',(e)=>{
                        this.msgs = e.messages;
                        this.sound.play();
                    });
            },
            open(){
                this.show = !this.show;
            },
            close(){
                this.show = false;
            },
            shorten(str){
                return str.substring(0,20);
            }
        }
    }
</script>

<style scoped>
    .fa-envelope{
        font-size:35px;
    }
    .env:hover{
        background: #f1f1f1;
    }
    .env button{
        background:transparent;
        border:none;
    }
    .env{
        text-align:center;
        padding:5px;
        border-radius:15px;
        transition:0.1s;
    }
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
    a:hover{
        color:var(--main-blue);
        text-decoration:none;
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
        padding: 15px;
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
        background-size:cover;
        background-position:center;
        position: absolute;
        border-radius: 100%;
        width: 40px;
        height: 40px;
        font-size: 15px;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
    }
    .not-circle{
        margin-left:-15px;
    }
</style>
