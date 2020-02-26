<template>
	<div class="position-absolute m-top d-flex">
		<div v-tooltip="o.name" class="img_bubble" v-for="(o,i) in grouped" :style="{'background-image':'url('+o.img+')'}">{{o.count}}</div>
	</div>
</template>
<script>
	export default{
		name:"reactions",
		props:["reactions"],
		computed:{
			grouped(){
				var temp = [];
				var list = [];

				for (var i = 0; i < this.reactions.length; i++) {
					var r_id = this.reactions[i].id;
					if(temp[r_id] == null){
						temp[r_id] = this.reactions[i];
						temp[r_id].count = 1;
						list.push(r_id);
					}else{
						temp[r_id].count += 1;
					}
				}
				console.log(temp);
				var ret = [];
				for (var i = 0; i < list.length; i++) {
					ret.push(temp[list[i]]);
				}
				return ret;
			}
		}
	}
</script>
<style scoped>
	.img_bubble{
		background-position: center;
		background-size: cover;
		width:30px;
		height: 30px;
	}
</style>
