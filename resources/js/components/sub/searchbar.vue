<template>
    <div class="bar">
        <transition name="zoom">
            <input type="text" v-if="show" name="q" autocomplete="off">
        </transition>
        <i class="fas fa-search" @click="show = !show"></i>
    </div>
</template>

<script>
    export default {
        name: "searchbar",
        data(){
            return {
                show:false
            }
        }
    }
</script>

<style scoped>
    input{
        background:#f0f0f0;
        border:none;
        border-radius:3px;
        padding:8px 15px;
    }
    .bar{
        margin:0px 15px;
    }
    .fa-search{
        cursor:pointer;
    }
    *{
        user-select:none;
    }
</style>
