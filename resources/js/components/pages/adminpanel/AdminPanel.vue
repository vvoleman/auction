<template>
    <vs-sidebar static-position default-index="1" color="dark" class="sidebarx" spacer v-model="active">
        <vs-sidebar-item index="1" href="/admin/">
             Dashboard
        </vs-sidebar-item>

        <vs-divider icon-pack="fas" icon="fa-user" position="left">
            Uživatel
        </vs-divider>
        <vs-sidebar-item index="2" href="/admin/users">
            Nastavení uživatele
        </vs-sidebar-item>
        <vs-sidebar-item index="3" href="/admin/groups">
            Nastavení skupin
        </vs-sidebar-item>

        <vs-divider icon-pack="fas" icon="fa-store-alt" position="left">
            Prodeje
        </vs-divider>
        <vs-sidebar-item index="4">
            Nastavení kategorií
        </vs-sidebar-item>
        <vs-sidebar-item index="5">
            Historie prodejů
        </vs-sidebar-item>
    </vs-sidebar>
</template>

<script>
    export default {
        name: "AdminPanel",
        data(){
            return {
                active:true
            }
        }
    }
</script>
<style scoped>
    .sidebarx{
        height:100vh;
        font-size:22px;
        position:fixed;
    }
</style>
