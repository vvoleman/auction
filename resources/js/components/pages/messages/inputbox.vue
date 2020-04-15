<template>
	<div class="box d-flex justify-content-around align-items-stretch">
		<button class="col-1" disabled>
			<i class="far fa-image"></i>
		</button>
		<textarea @keyup.enter.exact.prevent="send" class="col-10" v-model="input"></textarea>
		<button class="col-1">
		<v-popover>

			  <i class="tooltip-target b3 far fa-smile"></i>

			<template slot="popover">
			    <emojibar @send="addEmoji"></emojibar>
			</template>
		</v-popover>
		</button>
	</div>
</template>
<script>
	import Emojibar from "./emojibar";
	export default{
		components:{Emojibar},
		name:"inputbox",
		data(){
			return {
				input:""
			}
		},
		methods:{
			addEmoji(text){
				this.input+=text;
			},
			send(e){
                if (e.keyCode == 13 && !e.shiftKey)
                {
                    // prevent default behavior
                    e.preventDefault();
                    if(this.input.length > 0){
                        this.$emit("send",this.input);
                        this.input = "";
                    }
                }

			}
		}
	}
</script>
<style scoped>
	.box{
		background-color: #f9f9f9;
		border-top:1px solid #dfdfdf;
        height:100%;
	}
	i{
		font-size:25px;
	}
	button{
		background-color: transparent;
		border:none;
	}
	textarea{
		border:1px solid #dfdfdf;
		resize: none;
		background:#fcfcfc;
	}
</style>
