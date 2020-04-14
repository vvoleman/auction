<template>
    <div class="col-md-8 mx-auto m-top3">
        <div>
            <h3 class="disabled description">Info</h3>
        </div>
        <div class="m-top2">
            <div>
                <phase class="col-md-12" :phase="phases[phase.state]" :date="phase.date"></phase>
            </div>
            <div class="col-md-12 d-md-flex justify-content-between m-top2">
                <offersell-info class="col-md-7" v-if="offersell != null"
                                :offersell="offersell"></offersell-info>

                <div class="col-md-4">
                    <offer-block :offer="offer"></offer-block>
                    <confirm-delivery @click="sendConfirmation" class="m-top" v-if="offersell != null && offersell.buyer.you && phase.state != 'finished'"></confirm-delivery>
                </div>
            </div>

        </div>
        <div v-if="phase.state == 'confirmed'" class="m-top3">
            <div>
                <h3 class="disabled description">Další krok</h3>
            </div>
            <div class="m-top2 d-md-flex justify-content-around align-items-start">
                <div class="col-md-5">
                    <next-step :nextStep="nextStep[offer.delivery.name]"></next-step>
                </div>
                <div class="col-md-5">
                    <chat v-if="offer.delivery.name == 'personal'" :new_message="newMessage" :os_id="offersell.id"
                          :you_uuid="getUuid(true)" :opposite_uuid="getUuid(false)"></chat>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Phase from "./phase";
    import ConfirmDelivery from "./confirm-delivery";
    import OfferBlock from "./offer-block";
    import OffersellInfo from "./offersell-info";
    import NextStep from "./delivery/NextStep";
    import Chat from "./delivery/Chat";

    export default {
        name: "show-offersell",
        components: {NextStep, OffersellInfo, OfferBlock, Phase, Chat, ConfirmDelivery},
        props: ['datas'],
        data() {
            return {
                offer: {
                    name: "",
                    img: "",
                    url: "",
                    price: 0,
                    currency: "",
                    delivery: {label: "", name: ""},
                    payment: "",
                    created_at: ""
                },
                offersell: null,
                nextStep: {
                    personal: "dohodnutí o předání prostřednictvím chatu",
                    cp: "udání kódu zásilky"
                },
                newMessage: null,
                phases:{
                    confirmed:"Žádost přijata",
                    denied:"Žádost zamítnuta",
                    shipped:"Objenávka odeslána",
                    finished:"Objednávka doručena"
                }
            }
        },
        mounted() {
            var temp = JSON.parse(this.datas);
            this.offer = temp.offer;
            this.offersell = temp.offersell;

            this.startListening();
        },
        methods: {
            startListening() {
                Echo.private(`offersell.info.${this.offersell.id}`)
                    .listen('NewOffersellMessage', e => {
                        this.newMessage = e.message;
                    })
                    .listen('ChangeOffersellStatus', e => {
                        this.$snotify.info(`Stav objednávky změněn na '${this.phases[e.status]}'`);
                        this.offersell.status = {
                            name:e.status,
                            date:e.date
                        };
                    });
            },
            sendConfirmation(){
                axios.post(`/offersell/${this.offersell.id}/changeStatus`,{
                    new_status:"finished",
                    os_id:this.offersell.id
                })
                    .then(response=>{
                        if(response.data.response != 200){
                            this.$snotify.error("Nelze změnit stav objednávky!");
                        }
                    })
                    .catch(e=>{
                        this.$snotify.error("Nelze změnit stav objednávky!");
                    })
            },
            getUuid(you) {
                if (this.offersell == null) return "";
                if (this.offersell.buyer.you == you) {
                    return this.offersell.buyer.uuid
                }
                if (this.offersell.seller.you == you) {
                    return this.offersell.seller.uuid
                }
                return "";
            }
        },
        computed:{
            phase(){
                if(this.offersell == null){
                    return {
                        state:"",
                        date:""
                    }
                }else{
                    return {
                        state:this.offersell.status.name,
                        date:this.offersell.status.timestamp
                    }
                }
            }
        }

    }
</script>

<style scoped>
    .description{
        font-family:Raleway;
        text-transform:uppercase;
        color:#ccc;
        user-select:none;
        text-align:center;
    }
</style>
