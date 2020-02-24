<template>
    <div class="sidebar col-md-3">
        <div class="search-input d-flex justify-content-center align-items-end">
            <input type="text" class="m-top col-7" placeholder="Hledej...">
            <button class="btn btn-blue col-1"><i class="fas fa-search"></i></button>
        </div>
        <hr>
        <div class="contacts col-md-11 mx-auto">
            <div class="contact d-flex" v-for="(o,i) in contacts">
                <div class="img_bubble" :style="{'background-image':'url('+o.img+')'}"></div>
                <div class="label">
                    <b class="d-block">{{o.name}}</b>
                    <span>{{o.text}}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "sidebar",
        data(){
            return {
                contacts:[
                    {
                        name:"Marco",
                        text:"Text ot ofjsajk",
                        img:"https://www.aldergrovestar.com/wp-content/uploads/2019/07/17649457_web1_raccoon-pic-GPS.jpg"
                    },
                    {
                        name:"Marco",
                        text:"Text ot ofjsajk",
                        img:"https://www.nwf.org/-/media/NEW-WEBSITE/Shared-Folder/Wildlife/Mammals/mammal_raccoon-wisconsin_mary-braatz_600x300.ashx"
                    },
                    {
                        name:"Marco",
                        text:"Text ot ofjsajk",
                        img:"https://curiodyssey.org/wp-content/uploads/bb-plugin/cache/xMammals-Raccoon-square.jpg.pagespeed.ic.W5-0FMTZBa.jpg"
                    }
                ]
            }
        }
    }
</script>

<style scoped>
    .img_bubble{
        background-position: center;
        background-size:cover;
        width:50px;
        height:50px;
        border:2px solid #888;
    }
    .sidebar{
        background:#f9f9f9;
    }
    .contact{
        margin:20px 0;
    }
    .search-input input{
        border:1px solid #dedede;
        padding:8px 1px;
        height:40px;
    }
    .search-input button{
        height:40px;
        border-top-left-radius:0px;
        border-bottom-left-radius:0px;
    }
    .label{
        margin-left:25px;
    }
</style>
