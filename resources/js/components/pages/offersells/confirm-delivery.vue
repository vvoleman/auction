<template>
    <div class="white_box">
        <button :disabled="disabled" class="btn btn-danger btn-block" @click="sendConfirmation">Potvrdit převzetí</button>
    </div>
</template>

<script>
    export default {
        name: "confirm-delivery",
        data(){
            return {
                disabled:false
            }
        },
        methods:{
            sendConfirmation(){
                this.disabled =  true;
                this.$emit("click");
            }
        }
    }
</script>

<style scoped>

</style>
