<template>
    <div class="col-md-11 m-top mx-auto d-md-flex no-padding align-content-stretch box" style="margin-bottom: 20px;">
        <div class="col-md-4 d-flex no-padding">
            <div class="col-12 left-bar no-padding">
                <button class="btn btn-block btn-success bp" @click="openNew">Nová skupina</button>
                <div>
                    <transition name="fade" mode="out-in">
                        <loader key="load" v-if="groups.length == 0" class="m-top"></loader>
                        <groups-list v-else key="content" :groups="groups" @delete="deleteGroup" @clicked="listClicked"></groups-list>
                    </transition>
                </div>
            </div>
        </div>
        <div class="col-md-8 right no-padding">
           <transition name="fade" mode="out-in">
               <div key="default" v-if="(!show.edit_group && !show.new_group) || (show.edit_group && show.new_group)" class="m-top">
                    <div class="mx-auto mt-auto mb-auto col-6 text-center m-center">
                        <h4 class="text-muted">Vyberte skupinu</h4>
                    </div>
               </div>
               <edit-group key="edit" v-if="show.edit_group && !show.new_group && show.edit_index != null"
                           :id="current.id_g"
                           :selected="current.permissions"
                           :group_name="current.name"
                           :all_perms="all_perms"
                           @save="editSaved"
                           @close="closeEdit"></edit-group>
               <new-group key="new" v-if="show.new_group && !show.edit_group"
                          :all_perms="all_perms"
                          @save="newSaved"
                          @close="closeNew"
               ></new-group>
           </transition>
        </div>
    </div>
</template>

<script>
    import GroupsList from "./GroupsList";
    import EditGroup from "./EditGroup";
    import NewGroup from "./NewGroup";
    import Loader from "../../sub/Loader";

    export default {
        name: "config-pages",
        components: {Loader, NewGroup, EditGroup, GroupsList},
        data(){
            return {
                show:{
                    edit_group:false,
                    edit_index:null,
                    new_group:false
                },
                groups:[],
                all_perms:[]
            }
        },
        mounted(){
            this.getPerms();
            this.getGroups();
        },
        methods:{
            deleteGroup(i){
                this.closeEdit();
                if(confirm("Opravdu si přejete smazat skupinu '"+this.groups[i].name+"'?")){
                    axios.post("/ajax/admin/deleteGroup",{delete_group:this.groups[i].id_g})
                        .then((response)=>{
                            if(response.data.done){
                                this.groups.splice(i,1);
                                this.$snotify.success("Skupina byla úspěšně smazána!");
                            }else{
                                this.$snotify.error("Nebylo možné smazat skupinu!");
                            }

                        })
                        .catch((e)=>{
                            this.$snotify.error("Nebylo možné smazat skupinu!");
                        })
                }
            },
            openNew(){
                this.show.edit_group = false;
                this.show.edit_index = null;
                this.show.new_group = true;
            },
            closeNew(){
                this.show.new_group = false;
            },
            editSaved(data){
                this.$snotify.info('Upravuji skupinu...');
                axios.post("/ajax/admin/editGroup",data)
                    .then((response)=>{
                        if(response.data.done){
                            this.$set(this.groups,this.show.edit_index,response.data.group);
                            this.$snotify.success('Skupina byla úspěšně upravena!');
                        }else{
                            this.$snotify.error('Nebylo možné upravit skupinu!');
                        }
                    });
            },
            newSaved(data){
                this.$snotify.info('Přidávám skupinu...');
                axios.post("/ajax/admin/addGroup",data)
                    .then((response)=>{
                        if(response.data.done){
                            this.groups.push(response.data.group)
                            this.$snotify.success('Skupina byla úspěšně přidána!');
                        }else{
                            this.$snotify.error('Nebylo možné upravit skupinu!');
                        }
                    });
            },
            closeEdit(){
                this.show.edit_index = null;
                this.show.edit_group = false;
            },
            getPerms() {
                axios.get("/ajax/admin/getPermissions")
                    .then((response) => {
                        this.all_perms = response.data;
                    })
                    .catch((e) => {
                        console.log(e);
                    });
            },
            getGroups(){
                axios.get("/ajax/admin/getGroups")
                    .then((response)=>{
                        this.groups = response.data;
                    })
                    .catch((e)=>{
                        console.log(e);
                    });
            },
            listClicked(i){
                this.show.new_group = false;
                this.show.edit_index = i;
                this.show.edit_group = true;

            },
        },
        computed:{
            current(){
                if(this.show.edit_index != null){
                    return this.groups[this.show.edit_index];
                }
                return [];
            }
        }
    }
</script>

<style scoped>
    .bp {
        padding: 15px;
        border-bottom-left-radius: 0;
        font-size:23px;
        border-bottom-right-radius: 0;
    }

    .m-center{
        user-select: none;
        margin-top: 0;
        margin-bottom: 0;
    }
    .left-bar {
        margin-top: 0;
        margin-bottom: 0;
    }

    .left-bar > div {
        height: 60vh;
        overflow: auto;
    }
    .right{
        background: #d3d3d3;
    }
    .box{
        background: #c5c5c5;
    }
</style>
