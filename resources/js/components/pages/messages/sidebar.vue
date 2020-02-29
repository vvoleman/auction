<template>
    <div class="sidebar">
        <div class="upper d-flex justify-content-between align-items-center col-12 mx-auto sticky-top">
            <div class="h">Chaty</div>
            <i @click="new_msg = true" class="fas fa-edit new-message"></i>
        </div>
        <new-conversation @msgSend="sendNewMsg" @close="new_msg = false" v-if="new_msg"></new-conversation>
        <div class="m-top search-input">
            <input @keydown.esc="search = ''" v-model="search" type="text" autocomplete="off" class="col-12 mx-auto">
        </div>
        <hr>
        <div class="contacts">
            <transition name="fade" mode="out-in">
                <div key="empty" class="text-center" v-if="!loading && contacts_filtered.length == 0">Žádné kontakty</div>
                <loader key="load" v-if="loading"></loader>
                <div key="data" v-if="!loading && contacts_filtered.length > 0">
                    <div :class="{'selected':o.conversation_uuid==opened,'unread':o.last_msg.seen_at==null}" @click="open(o.conversation_uuid)" v-for="(o,i) in contacts_filtered" class="contact d-flex justify-content-between">
                        <div class="d-flex">
                            <div class="img_bubble" :style="{'background-image':'url('+o.user.img+')'}"></div>
                            <div class="m-left">
                                <div class="name">{{o.user.name}}</div>
                                <div class="second"><span v-if="o.last_msg.you">Vy: </span>{{short_str(o.last_msg.message)}}</div>
                            </div>
                        </div>
                        <div><span class="second">{{o.last_msg.sent_at}}</span></div>
                    </div>
                </div>
                <div key="error" v-if="error">
                    <div class="alert alert-danger text-center">Nelze načíst kontakty</div>
                </div>
            </transition>
        </div>
    </div>
</template>

<script>
    import NewConversation from "./newConversation";
    import Loader from "../../sub/Loader";
    export default {
        name: "sidebar",
        components: {Loader, NewConversation},
        props:{
            loading:{
                type:Boolean,
                default:()=>{return false}
            },
            error:{
                type:Boolean,
                default:()=>{return false}
            },
            contacts:{
                type:Array,
                default:()=>{return []}
            },
            opened:{
                type:String,
                default:()=>{return ""}
            }
        },
        data(){
            return {
                new_msg:false,
                search:"",
            }
        },
        computed:{
            contacts_filtered(){
                return this.contacts.filter((x)=>{return x.user.name.toLowerCase().indexOf(this.search.toLowerCase()) != -1});
            }
        },
        methods:{
            open(uuid){
                this.$emit("open",uuid);
            },
            closeNewMsg(){
                this.new_msg = false;
            },
            sendNewMsg(data){
                this.$emit("newMsg",data);
            },
            alterSidebar(data){
                var match = this.contacts.findIndex((x)=>{
                    return x.conversation_uuid == data.conversation_uuid;
                });

                //if match != -1, replace last msg of that index, otherwise put new msg as first
                if(match != -1){
                    var temp = this.contacts[match];
                    temp.last_msg = data.last_msg;
                    this.contacts.splice(match,1);
                    this.contacts.unshift(temp);
                }else{
                    this.contacts.unshift(data);
                }
            },
            short_str(str){
                return str.substring(0,12)+((str.length>12)?"...":"");
            }
        }
    }
</script>

<style scoped>

    .unseen{
        background: gold;
    }
    .img_bubble{
        background-position: center;
        background-size:cover;
        width:50px;
        height:50px;
        border:2px solid #888;
    }
    .upper{
        padding:10px;
        background:#f9f9f9;
        border-bottom:1px solid #dfdfdf;
    }
    .sidebar{
        background:#f9f9f9;
        position:absolute;
        height:90vh;
        overflow:auto;
        border-right:1px solid #dfdfdf;
    }
    .search-input input{
        border:1px solid #dfdfdf;
        border-radius:5px;
        background: #f0f0f0;
        padding:8px 1px;
        height:40px;
    }
    .search-input button{
        height:40px;
        border-top-left-radius:0px;
        border-bottom-left-radius:0px;
    }
    .upper .h{
        font-size:25px;
        font-weight: bold;
    }
    .new-message{
        font-size:22px;
        padding:10px;
        border-radius:100%;
        transition:0.2s;
        cursor:pointer;
    }
    .new-message:hover{
        background:#e9e9e9;
    }
    .contact{
        padding:15px;
        cursor:pointer;
        transition:0.1s;
    }
    .contact:hover:not(.selected){
        background:#f0f0f0;
    }
    .contact .name{
        color:black;
    }
    .contact .second{
        font-size:15px;
        color:#aaa;
    }
    .selected{
        background:#d0d0d0;
    }
    .selected .second{
        color:#888;
    }
    ::-webkit-scrollbar-track{
        background: transparent;
        border-right: 1px solid #dfdfdf;
    }
</style>
