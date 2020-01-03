<template>
    <modal @close="close">
        <h5 slot="header">Smazat žádost o koupi</h5>
        <div slot="body" class="col-xl-10 mx-auto">
            <h4 class="text-center">Opravdu si přejete smazat vaší nepotvrzenou žádost?</h4>
            <hr>
            <div class="col-md-6 col-10 d-flex confirm mx-auto m-top2">
                <button class="col-6 btn" @click="remove">Ano</button>
                <button class="col-6 btn" @click="close">Ne</button>
            </div>
        </div>
        <div slot="footer">
            <button class="btn btn-danger" @click="close">Zavřít</button>
        </div>
    </modal>
</template>

<script>
    export default {
        name: "remove-sell",
        props:["offer_id"],
        methods:{
            close(){
                this.$emit("close");
            },
            remove(){
                axios.post('/ajax/offers/removeOfferSell',{
                    offer_id:this.offer_id
                })
                    .then((response)=>{
                        this.$snotify.success(response.data.message);
                        this.$emit("save");
                        this.close();
                    })
                    .catch((error,o)=>{
                        console.log(error,o);
                    })
            }
        }
    }
</script>

<style scoped>
    .confirm .btn:first-child{
        background: #2fa265;
        border-top-right-radius:0;
        border-bottom-right-radius:0;
    }
    .confirm .btn:last-child{
        background: #e25551;
        border-top-left-radius:0;
        border-bottom-left-radius:0;
    }
</style>
