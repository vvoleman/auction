<template>
    <div class="d-flex">
        <sidebar class="col-lg-2"></sidebar>
        <chat class="offset-lg-2 col-lg-10" style="padding-left:0;padding-right:0"></chat>
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
