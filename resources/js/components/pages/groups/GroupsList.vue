<template>
    <div>
        <div v-for="(o,i) in groups" class="col-12 box">
            <h6>{{o.name}}</h6>
        </div>
    </div>
</template>

<script>
    export default {
        name: "GroupsList",
        data(){
            return {
                groups:[
                    {name:"Administrace"},
                    {name:"Administrace"},
                    {name:"Administrace"},
                    {name:"Administrace"},
                    {name:"Administrace"},
                    {name:"Administrace"},
                    {name:"Administrace"},
                    {name:"Administrace"},
                    {name:"Administrace"},
                    {name:"Administrace"},
                    {name:"Administrace"},
                    {name:"Administrace"},
                    {name:"Administrace"},
                    {name:"Administrace"},
                    {name:"Administrace"},
                ]
            }
        }
    }
</script>

<style scoped>
    .box{
        padding:15px;
        text-align: center;
        background: #e5e5e5;
    }
</style>
