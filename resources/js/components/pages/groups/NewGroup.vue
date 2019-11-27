<template>
    <div class="main">
        <div class="col-md-10 mx-auto m-top2">
            <div class="form-group row align-items-center justify-content-center">
                <label for="staticEmail" class="col-form-label bigger">Název</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="staticEmail" v-model="name">
                </div>
                <button class="btn btn-danger" @click="close">Zavřít</button>
                <button :disabled="(name.length == 0)" class="btn btn-success" @click="save">Uložit</button>
            </div>
            <div class="row w-100 mx-auto m-top3 justify-content-center">
                <span class="bigger d-block">Oprávnění</span>
                <manage-perms @change="existingChanged" class="m-top" :existing="existing" style="margin-bottom:20px" :all_perms="all_perms"></manage-perms>
            </div>
        </div>
    </div>
</template>

<script>
    import ManagePerms from "./ManagePerms";
    export default {
        name: "NewGroup",
        props:["all_perms"],
        components: {ManagePerms},
        data(){
            return {
                name:"",
                existing:[]
            }
        },
        methods:{
            existingChanged(data){
                this.existing = data;
            },
            save(){
                if(this.name.length == 0) return;
                this.$emit("save",this.res);
            },
            close(){
                this.$emit("close");
            }
        },
        computed:{
            res(){
                return {
                    name:this.name,
                    permissions:this.existing
                }
            }
        }
    }
</script>

<style scoped>

</style>
