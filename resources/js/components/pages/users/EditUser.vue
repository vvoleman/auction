<template>
    <div>
        <modal @close="close" @save="save">
            <div slot="header">
                Úprava uživatele
            </div>
            <div slot="body">
                <div class="form-group">
                    <label>Skupina</label>
                    <select v-model="group_id">
                        <option v-for="(o,i) in groups" :value="o.id_g">{{o.name}}</option>
                    </select>
                </div>
            </div>
        </modal>
    </div>
</template>

<script>
    export default {
        name: "EditUser",
        props:["g_id","g"],
        data(){
            return {
                group_id:this.g_id,
                groups:this.g
            }
        },
        methods:{
            close(){
                this.$emit("close");
            },
            save(){
                this.$emit("save",{group_id:this.group_id});
            }
        }
    }
</script>

<style scoped>

</style>
