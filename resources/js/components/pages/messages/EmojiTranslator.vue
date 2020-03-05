<template>
	
</template>
<script>
	export default{
		name:"EmojiTranslator",
		props:["str"],
		data(){
			emojis:[
				{
					id:1,
					img:"/assets/images/emojis/happy.png",
					title:"šťastný"
				},
				{
					id:2,
					img:"/assets/images/emojis/sad.png",
					title:"smutný"
				},
				{
					id:3,
					img:"/assets/images/emojis/angry.png",
					title:"naštvaný"
				},
				{
					id:4,
					img:"/assets/images/emojis/surprised.png",
					title:"překvapený"
				},
			],
			translateAs:[
				":D"=>1,
				":-D"=>1,
				":'("=>2,
				":("=>2,
				">:("=>3,
				":o"=>4,
				"😀"=>1,
				"😢"=>2,
				"😠"=>3,
				"😮"=>4
			]
		},
		methods:{
			checkForMatch(){
				for (var i = 0; i < translateAs.length; i++) {
					translateAs[i]
				}
			}
		}
	}
</script>
<style scoped>
	
</style>