<template>
    <div>
        <div v-for="(o,i) in groups" class="col-12 box d-flex justify-content-between" @mouseenter="hover = i"
             @mouseleave="hover = null">
            <h6 @click="clicked(i)">{{o.name}}</h6>
            <div>
                <i class="fas fa-trash" :class="{'text-danger':!o.isDefault,'text-muted':o.isDefault}"
                   :title="(o.isDefault) ? 'Tuto skupinu nelze smazat!' : ''" v-if="hover == i"
                   @click="deleteIt(i)"></i>
                <i class="fas fa-info m-left" @click="history = i"></i>
            </div>
        </div>
        <show-history v-if="history != null" :group_id="groups[history].id_g" @close="closeHistory"></show-history>
    </div>
</template>

<script>
    import ShowHistory from "./ShowHistory";
    export default {
        name: "GroupsList",
        components: {ShowHistory},
        props: ["groups"],
        data() {
            return {
                hover: null,
                history:null
            }
        },
        methods: {
            clicked(i) {
                this.$emit("clicked", i);
            },
            deleteIt(i) {
                if (this.groups[i].isDefault) {
                    return;
                }
                this.$emit("delete", i);
            },
            closeHistory(){
                this.history = null;
            }
        }
    }
</script>

<style scoped>
    .box {
        padding: 15px;
        padding-left: 30px;
        padding-right: 30px;
        text-align: center;
        background: #e5e5e5;
    }
    .fas:not(.text-muted){
        cursor:pointer;
    }
</style>
