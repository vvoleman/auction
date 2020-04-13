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
						name:"Wtf?",
						img:"https://i.imgflip.com/34t5np.png"
					},
					{
						id:2,
						name:"It ain't much",
						img:"https://i.kym-cdn.com/photos/images/newsfeed/001/445/963/523.jpg"
					},
					{
						id:3,
						name:"Smutný",
						img:"https://i.ytimg.com/vi/hAsZCTL__lo/maxresdefault.jpg"
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
