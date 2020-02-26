<template>
    <div class="d-flex position-fixed">
        <sidebar class="col-rl-2 col-md-3"></sidebar>
        <chat class="offset-rl-2 offset-md-3 col-rl-10 col-md-9" style="padding-left:0;padding-right:0"></chat>
    </div>
</template>

<script>
    import Sidebar from "./sidebar";
    import Chat from "./chat";
    export default {
        name: "messenger",
        components: {Sidebar, Chat}
    }
</script>

<style scoped>

</style>
