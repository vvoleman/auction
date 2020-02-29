<template>
    <modal @close="close">
        <div slot="header"><h3>Nová zpráva</h3></div>
        <div slot="body">
            <div class="col-md-6 mx-auto">
                <div class="form-group">
                    <label>Jméno</label>
                    <v-select v-model="selected" :options="users_search" @search="load" @change="change"></v-select>
                </div>
                <div class="form-group">
                    <label>Zpráva</label>
                    <textarea v-model="message" class="form-control" style="height: 30vh"></textarea>
                </div>
            </div>
        </div>
        <div slot="footer">
            <button class="btn btn-danger" @click="close">Zavřít</button>
            <button class="btn btn-success" @click="send" :disabled="!canSend">Odeslat</button>
        </div>
    </modal>
</template>

<script>
    export default {
        name: "newConversation",
        data(){
            return {
                users_search:[],
                selected:null,
                message:""
            }
        },
        methods:{
            change(o){
            },
            close(){
                this.$emit("close");
            },
            send(){
                if(this.canSend){
                    this.$emit("msgSend",{to:this.selected.code,message:this.message});
                    this.close();
                }
            },
            load(search,loading){
                //if(search.length == 0) return;
                loading(true);
                axios.get('/ajax/messages/users',{
                    params:{
                        string:search
                    }
                })
                    .then((response)=>{
                        this.users_search = response.data.data;
                        loading(false);
                    })
                    .catch(()=>{
                        loading(false);
                    });
            }
        },
        computed:{
            canSend(){
                return this.selected != null && this.message.length > 0;
            }
        }
    }
</script>

<style scoped>

</style>
