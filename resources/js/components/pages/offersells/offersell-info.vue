<template>
    <div class="d-flex justify-content-between align-items-start">
        <div class="d-md-flex col-md-6">
            <user-info class="col-12 white_box" :user="offersell.seller" name="Prodejce"></user-info>
        </div>
        <div class="d-md-flex col-md-6">
            <user-info class="col-12 white_box" :user="offersell.buyer" name="Kupující"></user-info>
        </div>
    </div>
</template>

<script>
    import UserImg from "./user/user-img";
    import UserInfo from "./user/user-info";
    export default {
        name: "offersell-info",
        components: {UserInfo, UserImg},
        props:['offersell']
    }
</script>

<style scoped>

</style>
