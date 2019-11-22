<template>
    <transition name="fade">
        <button class="up_link fas fa-arrow-up" v-if="show_up" @click="goUp">

        </button>
    </transition>
</template>

<script>
    export default {
        name: "GoUp",
        props:["el_id"],
        data(){
            return {
                show_up:false
            }
        },
        created () {
            window.addEventListener('scroll', this.handleScroll);
        },
        destroyed () {
            window.removeEventListener('scroll', this.handleScroll);
        },
        methods: {
            handleScroll(e) {
                this.show_up = (document.getElementById(this.el_id).getBoundingClientRect().y < 0);
                console.log(this.show_up);
            },
            goUp(){
                window.scrollBy(0,document.getElementById(this.el_id).getBoundingClientRect().top);
            }
        }
    }
</script>

<style scoped>
    .up_link{
        position: fixed;
        display:flex;
        justify-content: center;
        align-items: center;
        top:90%;
        right:1%;
        width: 50px;
        height:50px;
        background: var(--main-blue);
        padding:10px;
        color:white;
        border-radius: 30px;
    }
</style>
