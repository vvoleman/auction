<template>
	<div class="message d-flex align-items-center" :class="{'msg-left':!you,'msg-right':you}">
		<div>
			<div v-tooltip="getTime(message.sent_at)" class="msg_content">
				{{message.message}}
			</div>
			<reactions :reactions="getReactions"></reactions>
		</div>
		
		<v-popover>
			  <i class="tooltip-target b3 far fa-smile"></i>

			  <template slot="popover">
			    <reactionbar @changeReaction="changeReaction"></reactionbar>
			  </template>
		</v-popover>
	</div>
</template>
<script>
	import Reactionbar from "./reactionbar";
	import Reactions from "./reactions";
	export default{
		name:"message",
		components:{Reactionbar,Reactions},
		props:{
			message:{
				type:Object,
				required:true
			},
			you:{
				type:Boolean,
				default:()=>{return true}
			},
			user:{
				type:Object,
				required:true
			}
		},
		data(){
			return {
				reactions:{
					you:null,
					opposite:null
				}
			}
		},
		methods:{
			getTime(u){
				var d = new Date(u*1000);
				return this.withZero(d.getDate())+". "+this.withZero(d.getMonth()+1)+". "+d.getFullYear()+" "+this.withZero(d.getHours())+":"+this.withZero(d.getMinutes());
			},
			withZero(n){
				return ((n<=9) ? "0" : "")+n;
			},
			changeReaction(obj){
				this.reactions.you = obj;
			}
		},
		computed:{
			getReactions(){
				var temp = [];
				if(this.reactions.you != null) temp.push(this.reactions.you);
				if(this.reactions.opposite != null) temp.push(this.reactions.opposite);
				return temp;
			}
		}
	}
</script>
<style scoped>
	.tooltip.popover .popover-inner {
	  background: #f9f9f9;
	  color: black;
	  padding: 10px !important;
	  border-radius: 5px;
	  box-shadow: 0 5px 30px rgba(0, 0, 0, 0.1);
	}
	.tooltip.popover .popover-arrow {
	  border-color: #f9f9f9;
	}
	.message{
		margin:5px;
	}
	.msg_content{
		max-width: 40%;
		padding:10px;
		border-radius:10px;
	}
	.msg-right .msg_content{
		background-color: var(--main-blue);
		color:white;
	}
	.msg-left .msg_content{
		background-color: #d5d5d5;
	}
	.msg-right{
		flex-direction: row-reverse;
	}
	.far{
		transition: 0.2s;
		display: none;
	}
	.message:hover .far{
		display: block;
	}
	.msg-left .far{
		margin-left:10px;
	}
	.msg-right .far{
		margin-right:10px;
	}
</style>