<template>
    <div>
        <sidebar></sidebar>
        <chat></chat>
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
