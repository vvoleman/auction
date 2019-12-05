<template>
    <div class="white_box d-flex align-items-center">
        <div>
            <label>Seřadit dle:</label>
            <select v-model="sel_sort">
                <option v-for="(o,i) in sorts" :value="i">{{o.label}}</option>
            </select>
        </div>
        <div>
            <label>Zobrazit:</label>
            <select v-model="sel_filter">
                <option v-for="(o,i) in filters" :value="i">{{o.label}}</option>
            </select>
        </div>
        <div>
            <label>Pořadí:</label>
            <select v-model="dir">
                <option value="1">Od největšího</option>
                <option value="0">Od nejmenšího</option>
            </select>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Navbar",
        data(){
            return {
                sorts:[
                    {name:"name",label:"Názvu"},
                    {name:"date",label:"Data přidání"}
                ],
                filters:[
                    {name:"all",label:"Vše"},
                    {name:"deleted",label:"Jen smazané"},
                    {name:"active",label:"Jen aktivní"},
                    {name:"expired",label:"Jen expirované"}
                ],
                sel_sort:0,
                sel_filter:0,
                dir:1
            }
        },
        mounted(){
            this.$emit("change",this.selected);
        },
        watch:{
            sel_sort(){
                this.$emit("change",this.selected);
            },
            sel_filter(){
                this.$emit("change",this.selected);
            }
        },
        computed:{
            selected(){
                return {
                    sort:this.sorts[this.sel_sort].name,
                    filter:this.filters[this.sel_filter].name,
                    dir:this.dir
                };
            }
        }
    }
</script>

<style scoped>

</style>
