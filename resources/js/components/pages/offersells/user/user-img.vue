<template>
    <div :class="{'you':you}" class="img_bubble" :style="{'background-image':'url('+url+')'}">

    </div>
</template>

<script>
    export default {
        name: "user-img",
        props:['url','you']
    }
</script>

<style scoped>
    .img_bubble{
        background-position:center;
        background-size:cover;
        width:50px;
        height:50px;
    }
    .you.img_bubble{
        border:1px solid orange;
    }
</style>
