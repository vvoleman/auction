<template>
	<div class="position-fixed chat">
        <div class="header d-flex col-12 align-items-center justify-content-between sticky-top">
            <div class="d-flex align-items-center">
                <div class="img_bubble" :style="{'background-image':'url('+users[0].img+')'}"></div>
                <div class="name m-left">{{users[0].name}}</div>
            </div>
            <button class="resize" @click="hideNav">
                <i v-if="!fullscreen" class="fas fa-compress"></i>
                <i v-else class="fas fa-expand"></i>
            </button>
        </div>
        <div class="d-flex flex-column-reverse chatbox" style="padding:5px 15px;">
        	<message class="w-100" v-for="(o,i) in msgs" :key="o.message_uuid" :message="o" :user="getUser(o.author)"></message>
        </div>
        <div class="inputbox" style="padding-left: 0;padding-right: 0">
        	<inputbox @send="newMessage"></inputbox>
        </div>
    </div>
</template>
<script>
	import Message from "./message";
	import Inputbox from "./inputbox";
	export default{
		name:"chat",
        components:{Message,Inputbox},
        props:{
		    users:{
		        type:Array,
                default:()=>{return []}
            },
            msgs:{
                type:Array,
                default:()=>{return []}
            },
            canNext:{
		        type:Boolean,
                default:()=>{return false}
            }
        },
		data(){
			return {
			    fullscreen:false
			}
		},
        methods:{
		    getUser(uuid){
		        var match = this.users.filter((x)=>{
		            return x.uuid == uuid;
                });
		        if(match.length == 0){
		            return {
                        name:"",
                        img:"https://i.ytimg.com/vi/8CFwPaohYCk/maxresdefault.jpg"
                    };
                }
		        return match[0];
            },
            newMessage(str){
            	this.$emit("newMsg",str);
            },
            hideNav(){
		        var names = ["d-flex","d-none"];
		        var el = document.getElementsByClassName("navi")[0];
		        el.classList.remove(names[this.fullscreen ? 1 : 0]);
		        this.fullscreen = !this.fullscreen;
		        el.classList.add(names[this.fullscreen ? 1 : 0]);
            }
        }
	}
</script>
<style scoped>
    .chat{
        height:100vh;
    }
    .inputbox{
        height:10%;
    }
    .chatbox{
        overflow:auto;
        height:71%;
    }
    .img_bubble{
        width: 50px;
        height: 50px;
        background-position:center;
        background-size:cover;
    }
    .header .name{
        font-size:20px;
    }
    .header{
        height:10%;
        position:sticky;
        padding:5px;
        background: #f9f9f9;
        border-bottom:1px solid #dfdfdf;
    }
    button.resize{
        background:transparent;
        border:none;
        font-size:25px;
    }
</style>
