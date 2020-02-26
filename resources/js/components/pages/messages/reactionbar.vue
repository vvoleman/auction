<template>
	<div class="d-flex align-items-center">
		<button @click="select(i)" v-for="(o,i) in emotes">
			<div :class="{'clicked':clicked==i}" :title="o.name" class="img_bubble" :style="{'background-image':'url('+o.img+')'}" :key="i"></div>
		</button>
	</div>
</template>
<script>
	export default{
		name:"reactionbar",
		data(){
			return {
				emotes:[
					{
						id:1,
						name:"Super!",
						img:"https://cdn140.picsart.com/292494756016201.jpg?type=webp&to=min&r=1024"
					},
					{
						id:2,
						name:"Smutný",
						img:"https://cdn140.picsart.com/292494756016201.jpg?type=webp&to=min&r=1024"
					},
					{
						id:3,
						name:"More wtf",
						img:"https://cdn140.picsart.com/292494756016201.jpg?type=webp&to=min&r=1024"
					},
				],
				clicked:null
			}
		},
		methods:{
			select(i){
				this.clicked = (this.clicked == i) ? null : i;
				this.$emit("changeReaction",(this.clicked != null) ? this.emotes[this.clicked] : null);
			}
		}
	}
</script>
<style scoped>
	.img_bubble{
		width:30px;
		height:30px;
		background-size: cover;
		background-position: center;
	}
	button{
		border:none;
		background-color: Transparent;
		transition: 0.2s;
	}
	.img_bubble.clicked{
		border:3px solid var(--main-orange);
	}
	
</style>