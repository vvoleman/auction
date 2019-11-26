<template>
    <div class="col-md-11 m-top mx-auto d-md-flex no-padding align-content-stretch box">
        <div class="col-md-4 d-flex no-padding">
            <div class="col-12 left-bar no-padding">
                <button class="btn btn-block btn-success bp">Nová skupina</button>
                <div>
                    <groups-list v-if="false"></groups-list>
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
               <edit-group key="edit" v-if="show.edit_group && !show.new_group"></edit-group>
               <new-group key="new" v-if="show.new_group && !show.edit_group"></new-group>
           </transition>
        </div>
    </div>
</template>

<script>
    import GroupsList from "./GroupsList";
    import EditGroup from "./EditGroup";
    import NewGroup from "./NewGroup";

    export default {
        name: "config-pages",
        components: {NewGroup, EditGroup, GroupsList},
        data(){
            return {
                show:{
                    edit_group:true,
                    new_group:false
                }
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
