<template>
    <div class="col-12 d-flex main no-padding">
        <div class="mx-auto col-md-6">
            <div class="col-12 no-padding">
                <div class="head">Oprávnění</div>
            </div>
            <div class="row list">
                <transition name="fade" mode="out-in">
                    <loader key="load" v-if="all_perms.length == 0" class="m-top2"></loader>
                    <div key="cont" v-else class="row">
                        <div class="col-10 mx-auto d-flex justify-content-between item" v-for="(o,i) in available">
                            <span class="sm">{{o.permission}}</span>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-plus-circle text-success" @click="swapFrom(i)"></i>
                                <i class="fas fa-info m-left" @click="openInfo"></i>
                            </div>
                        </div>
                    </div>
                </transition>
            </div>
        </div>
        <div class="mx-auto col-md-6">
            <div class="col-12 no-padding">
                <div class="head">Vybráno</div>
            </div>
            <div class="row list align-content-start">
                <div class="col-10 mx-auto d-flex justify-content-between item" v-for="(o,i) in selected">
                    <span class="sm">{{o.permission}}</span>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-minus-circle text-danger" @click="swapTo(i)"></i>
                        <i class="fas fa-info m-left" @click="openInfo"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Loader from "../../sub/Loader";

    export default {
        name: "ManagePerms",
        components: {Loader},
        props: ["existing","all_perms"],
        data() {
            return {

                selected: (this.existing != null) ? this.existing : []
            }
        },
        methods: {
            swapFrom(all) {
                if (this.available[all] == null) {
                    return;
                }
                this.selected.push(this.available[all]);
            },
            swapTo(sel) {
                console.log("ff");
                if (this.selected[sel] == null) {
                    return;
                }
                this.selected.splice(sel, 1);
            },
            isSelected(i) {
                console.log("tady");
                return this.selected.filter((x, i) => {
                    console.log("f");
                    return x.id_p == this.all_perms[i].id_p;
                }).length > 0;
            },
            openInfo() {
                console.log("test");
            }
        },
        computed: {
            available() {
                let temp = this.all_perms;
                for (var i = 0; i < this.selected.length; i++) {
                    temp = temp.filter((val) => {
                        return val.id_p != this.selected[i].id_p;
                    })
                }
                return temp;
            }
        },
        watch:{
            selected(){
                this.$emit("change",this.selected);
            },
            existing(){
                this.selected = this.existing;
            }
        }
    }
</script>

<style scoped>
    .main {
        text-align: center;
    }

    .head {
        background: #242424;
        color: white;
        padding: 10px;
    }

    .item {
        text-align: left;
        padding: 5px;
        background-color: #d0d0d0;
        user-select: none;
    }
    .list{
        height: 300px;
        align-content:start;
        overflow-x: hidden;
    }
    .selected {
        border: 2px solid orange;
    }

    .fas {
        cursor: pointer;
    }
</style>
