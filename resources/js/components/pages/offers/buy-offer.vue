<template>
    <modal>
        <div slot="header">Zakoupit předmět</div>
        <div slot="body" class="col-md-8 mx-auto ">
            <p><b>Jak to funguje?</b></p>
            <ol>
                <li>Nejdříve zašleme Vaší žádost k potvrzení autorovi nabídky.</li>
                <li>Ten jí potvrdí a tím si ověříme, že nabídky opravdu platí a prodejce s prodejem opravdu souhlasí.</li>
                <li>Následně budete na základě typu platby vyzván k platbě nebo k domluvě předávajícího místa.</li>
            </ol>
            <table class="table" v-if="!buy_button">
                <thead>
                    <tr>
                        <th>Název</th>
                        <th>Cena</th>
                        <th>Typ dopravy</th>
                        <th>Typ platby</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{info.name}}</td>
                        <td>{{info.price}} {{info.currency}}</td>
                        <td>{{info.delivery}}</td>
                        <td>{{info.payment}}</td>
                    </tr>
                </tbody>
            </table>
            <div class="m-top3">
                <button :disabled="buy_button" @click="buy_button = true" class="btn btn-block btn-success col-sm-6 mx-auto">Zakoupit</button>
                <transition name="fade">
                <div v-if="buy_button" class="m-top2">
                    <set-info v-if="info.delivery == 'Česká pošta'" :address="info.address" :fullname="info.fullname" @change="infoChanged"></set-info>

                    <h5 class="text-center">Opravdu si přejete zakoupit nabídku?</h5>
                    <div class="col-md-6 col-10 d-flex confirm mx-auto m-top2">
                        <button class="col-6 btn" @click="buyClicked" :disabled="!this.canSubmit">Ano</button>
                        <button class="col-6 btn" @click="buy_button = false">Ne</button>
                    </div>
                </div>
                </transition>
            </div>
        </div>
        <div slot="footer"><button class="btn btn-danger" @click="close">Zavřít</button></div>
    </modal>
</template>

<script>
    import SetInfo from "./set-info";
    export default {
        name: "buy-offer",
        components: {SetInfo},
        props:["addresses","info"],
        data(){
            return{
                buy_button:false,
                fullname:this.info.fullname,
                address:this.info.address
            };
        },
        methods:{
            close(){
                this.$emit("close");
            },
            buyClicked(){
                this.buy_button = true;
                axios.post("/ajax/offers/newBuy",{
                    offer_id: this.info.offer_id,
                    address:this.address,
                    name:this.fullname
                })
                    .then((response)=>{
                        this.$snotify.success(response.data.message);
                        this.$emit("save");
                        this.close();
                        //Tož, teď se vrhni na backend, Vojtíku
                    })
                    .catch((error)=>{
                        this.$snotify.error("Při vytváření objednávky nastal problém!");
                    });

            },
            infoChanged(arr){
                this.fullname = arr.fullname;
                this.address = arr.address;
            }
        },
        computed:{
            canSubmit(){
                return this.fullname.length > 0 && this.address.length > 0;
            }
        }

    }
</script>

<style scoped>
    .confirm .btn{
        color:white;
    }
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
