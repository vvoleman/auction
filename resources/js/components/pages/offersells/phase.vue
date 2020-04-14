<template>
    <div class="white_box d-md-flex justify-content-around align-items-center">
        <h3>Fáze:</h3>
        <div>
            <span class="d-block"><b>{{phase}}</b></span>
            <span><small>{{date}}</small></span>
        </div>
    </div>
</template>

<script>
    export default {
        name: "phase",
        props:['phase','date'],
        data(){
            return {

            }
        }
    }
</script>

<style scoped>

</style>
