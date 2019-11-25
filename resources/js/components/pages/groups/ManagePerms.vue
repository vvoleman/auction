<template>
    <div class="col-12 d-flex main" style="overflow:auto">
        <div class="col-md-6">
            <div class="head">Oprávnění</div>

        </div>
        <div class="col-md-6">
            <div class="head">Vybrané</div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ManagePerms",
        props:["existing"],
        data(){
            return {
                all_perms:[],

                selected:(this.existing != null) ? this.existing : []
            }
        },
        mounted(){
            this.getPerms();
        },
        methods:{
            getPerms(){
                axios.get("/ajax/admin/getPermissions")
                    .then((response)=>{
                        this.all_perms = response.data;
                    })
                    .catch((e)=>{
                        console.log(e);
                    });
            },
            swapFrom(all){
                if(this.available[all] == null){
                    return;
                }
                this.selected.push(this.available[all]);
            },
            swapTo(sel){
                if(this.selected[sel] == null){
                    return;
                }
                this.selected.splice(sel,1);
            }
        },
        computed:{
            available(){
                let temp = this.all_perms;
                for(var i=0;i<this.selected.length;i++){
                    temp = temp.filter((val)=>{
                        return val.id_p != this.selected[i].id_p;
                    })
                }
                return temp;
            }
        }
    }
</script>

<style scoped>
    .main{
        text-align: center;
        border:1px solid black;
    }
</style>
