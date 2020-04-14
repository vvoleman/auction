<template>
    <div class="w-100">
        <div class="w-100 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <user-img :you="user.you" :url="user.img"></user-img>
                <img class="flag" :src="user.address.country.img">
                <b>{{user.fullname}}</b>
            </div>
            <button class="arrow" @click="down = !down"><i class="fas fa-caret-down" v-if="!down"></i><i v-else class="fas fa-caret-up"></i></button>
        </div>
        <transition name="fade">
            <div v-if="down">
                <hr>
                <div class="text-center">
                    <b>{{name}}</b>
                </div>
                <table class="table m-top">
                    <tr>
                        <td>Ulice:</td>
                        <td>{{user.address.street}}</td>
                    </tr>
                    <tr>
                        <td>PSČ:</td>
                        <td>{{user.address.zipcode}}</td>
                    </tr>
                    <tr>
                        <td>Město:</td>
                        <td>{{user.address.city}}</td>
                    </tr>
                    <tr>
                        <td>Kraj:</td>
                        <td>{{user.address.region.name}}</td>
                    </tr>
                    <tr>
                        <td>Země:</td>
                        <td>{{user.address.country.name}}</td>
                    </tr>
                </table>
            </div>
        </transition>
    </div>
</template>

<script>
    import UserImg from "./user-img";
    export default {
        name: "user-info",
        props:['user','name'],
        components: {UserImg},
        data(){
            return {
                down:false
            }
        }
    }
</script>

<style scoped>
    .arrow{
        padding:10px;
        text-align:center;
        width:40px;
        display:flex;
        align-items:center;
        justify-content:center;
        height:40px;
        border:none;
        border-radius:100%;
        background:#efefef;
    }
    b{
        margin-left: 10px;
    }
    .flag{
        width:20px;
        margin-left:10px;
        border:1px solid #eee;
    }
</style>
