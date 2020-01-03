<template>
    <div>
        <div class="form-group">
            <label>Doručit na adresu</label>
            <input type="text" class="form-control" v-model="new_address">
        </div>
        <div class="form-group">
            <label>Doručit na jméno</label>
            <input type="text" class="form-control" v-model="new_name">
        </div>
    </div>
</template>

<script>
    export default {
        name: "set-info",
        props:["address","fullname"],
        data(){
            return{
                new_address:this.address,
                new_name:this.fullname,
            }
        },
        methods:{
          sendNudes(){
              this.$emit("change",this.toReturn);
          }
        },
        watch:{
            new_address(){
                this.sendNudes();
            },
            new_name(){
                this.sendNudes();
            }
        },
        computed:{
            toReturn(){
                return {
                    fullname:this.new_name,
                    address:this.new_address
                }
            }
        }
    }
</script>

<style scoped>

</style>
