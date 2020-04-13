<template>
	<div class="d-flex flex-wrap">
		<button @click="send(i)" v-for="(o,i) in emoji" :key="i">{{o.text}}</button>
	</div>
</template>
<script>
	export default{
		name:"emojibar",
		data(){
			return {
				emoji:[
					{
						text:"😀",
						img:""
					},
					{
						text:"😮",
						img:""
					},
					{
						text:"😠",
						img:""
					},
					{
						text:"😢",
						img:""
					},
                    {
                        text:"¯\_(ツ)_/¯",
                        img:""
                    }
				]
			}
		},
		methods:{
			send(i){
				this.$emit("send",this.emoji[i].text);
			}
		}
	}
</script>
<style scoped>
	button{
		text-align: center;
		font-size:23px;
		border:none;
		background-color: transparent;
	}
</style>
