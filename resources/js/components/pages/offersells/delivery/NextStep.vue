<template>
    <div class="white_box">
        <h3>Další krok:</h3>
        <div>
            <span>{{nextStep}}</span>
        </div>
    </div>
</template>

<script>
    export default {
        name: "NextStep",
        props:['nextStep']
    }
</script>

<style scoped>

</style>
