<template>
    <div class="main">
        <div class="col-md-10 mx-auto m-top2">
            <div class="form-group row align-items-center justify-content-center">
                <label for="staticEmail" class="col-form-label bigger">Název</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="staticEmail" v-model="name">
                </div>
                <button class="btn btn-danger" @click="close">Zavřít</button>
                <button :disabled="!didChange" class="btn btn-success" @click="save">Uložit</button>
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
        name: "EditGroup",
        components: {ManagePerms},
        props:{
            selected:{
                default:()=>{return [];}
            },
            group_name:{
                default:()=>{return "";}
            },
            id:{
                required:true
            },
            all_perms:{required:true}
        },
        data(){
            return {
                existing:this.selected.slice(),
                og:{
                    existing:this.selected.slice(),
                    name:this.group_name.slice()
                },
                name:this.group_name.slice()
            }
        },
        methods:{
            existingChanged(data){
                this.existing = data;
            },
            close(){
                this.$emit('close');
            },
            save(){
                if(this.name.length > 0){
                    this.$emit("save",this.res);
                }
            }
        },
        watch:{
            selected(){
                this.existing = this.selected;
            },
            group_name(){
                this.name = this.group_name;
            }
        },
        computed:{
            didChange(){
                return (!_.isEqual(this.og.existing,this.existing) || !_.isEqual(this.og.name,this.name)) && this.name.length > 0;
            },
            res(){
                return {
                    id:this.id,
                    name:this.name,
                    permissions:this.existing.map((x)=>{return x.id_p})
                }
            }
        }
    }
</script>

<style scoped>
    .main{
        margin-top:0;
        margin-bottom:0;
    }
    .bigger{
        font-size:25px;
    }
</style>
