<template>
    <div class="col-12 d-flex main no-padding">
        <div class="mx-auto col-md-6">
            <div class="col-12 no-padding">
                <div class="head">Oprávnění</div>
            </div>
            <div class="row">
                <div class="col-10 mx-auto d-flex justify-content-between item" v-for="(o,i) in available">
                    <span class="sm">{{o.permission}}</span>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-plus-circle" @click="swapFrom(i)"></i>
                        <i class="fas fa-info m-left" @click="openInfo"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="mx-auto col-md-6">
            <div class="col-12 no-padding">
                <div class="head">Vybráno</div>
            </div>
            <div class="row">
                <div class="col-10 mx-auto d-flex justify-content-between item" v-for="(o,i) in selected">
                    <span class="sm">{{o.permission}}</span>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-minus-circle" @click="swapTo(i)">+</i>
                        <i class="fas fa-info" @click="openInfo"></i>
                    </div>
                </div>
            </div>
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
            toggleSelected(i){
                
            },
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
                console.log("ff");
                if(this.selected[sel] == null){
                    return;
                }
                this.selected.splice(sel,1);
            },
            isSelected(i){
                console.log("tady");
                return this.selected.filter((x,i) => {
                    console.log("f");
                    return x.id_p == this.all_perms[i].id_p;
                }).length > 0;
            },
            openInfo(){
                console.log("test");
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
    }
    .head{
        background:#242424;
        color:white;
        padding:10px;
    }
    .item{
        text-align: left;
        padding:5px;
        background-color: #d0d0d0;
        user-select: none;
    }
    .selected{
        border:2px solid orange;
    }
    .fas{
        cursor: pointer;
    }
</style>
