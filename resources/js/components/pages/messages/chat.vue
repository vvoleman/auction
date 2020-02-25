<template>
	<div class="">
        <div class="header d-flex col-12 align-items-center sticky-top">
            <div class="img_bubble" :style="{'background-image':'url('+users[0].img+')'}"></div>
            <div class="name m-left">{{users[0].name}}</div>
        </div>
    </div>
</template>
<script>
	export default{
		name:"chat",
		data(){
			return {
				messages:[
                    {
                        user:0,
                        message:"Ahoj",
                        sent_at:1582662531
                    },
                    {
                        user:0,
                        message:"Jak se daří?",
                        sent_at:1582662536
                    },
                    {
                        user:1,
                        message:"Dobrý, zrovna papám puding",
                        sent_at:1582662556
                    }
                ],
                users:[
                    {
                        name:"Trang",
                        img:"https://scontent.fprg1-1.fna.fbcdn.net/v/t1.0-1/p100x100/24993384_1639540139495372_1359110629522545278_n.jpg?_nc_cat=103&_nc_oc=AQk5dGCEbMSYCvHP6FXw3khiJyswpPf5jfo7BlIzRAUv_BZILyTZ-Mdq35D8xRPoR0xd0gih3onFxF5W_MyE97pH&_nc_ht=scontent.fprg1-1.fna&_nc_tp=6&oh=1fef8aceffba276ab17ca6e019c8c9d3&oe=5EBD220E"
                    },
                    {
                        name:"Vojta",
                        img:"https://imgc.allpostersimages.com/img/print/u-g-Q1A2C4K0.jpg?w=550&h=550&p=0"
                    }
                ]
			}
		},
        methods:{
		    getUser(i){
                var u = this.users[i];
                if(u == null){
                    u = {
                        name:"",
                        img:"https://i.ytimg.com/vi/8CFwPaohYCk/maxresdefault.jpg"
                    }
                }
                return u;
            }
        }
	}
</script>
<style scoped>
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
        padding:5px;
        background: #f9f9f9;
        border-bottom:1px solid #dfdfdf;
    }
</style>
