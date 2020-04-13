<template>
    <div class="white_box d-flex align-items-center">
        <div class="form-group">
            <label>Seřadit dle:</label>
            <select v-model="sel_sort" class="form-control">
                <option v-for="(o,i) in sorts" :value="i">{{o.label}}</option>
            </select>
        </div>
        <div class="form-group" style="margin-left:10px">
            <label>Zobrazit:</label>
            <select v-model="sel_filter" class="form-control">
                <option v-for="(o,i) in filters" :value="i">{{o.label}}</option>
            </select>
        </div>
        <div class="form-group" style="margin-left:10px">
            <label>Pořadí:</label>
            <select v-model="dir" class="form-control">
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
                    {name:"waiting",label:"Jen nepotvrzené"},
                    {name:"confirmed",label:"Jen potvrzené"},
                    {name:"denied",label:"Jen zamítnuté"},
                    {name:"shipped",label:"Jen v transportu"},
                    {name:"finished",label:"Jen přijaté"},
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
            },
            dir(){
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
    .white_box label{
        font-weight:bold;
    }
</style>
