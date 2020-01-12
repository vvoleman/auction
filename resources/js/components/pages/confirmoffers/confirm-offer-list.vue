<template>
    <div class="col-md-6 mx-auto">
        <!--<div class="white_box m-top3 text-center">
            <h3>Žádosti o koupi</h3>
            <span>k produktu "Vysavač fdsaf"</span>
        </div>
        <div class="d-flex align-items-end m-top">
            <h5 style="margin-right:15px">Řadit dle:</h5>
            <div class="d-flex">
                <div class="badge-filter" :class="{'filter-active':orderBy==0}" @click="orderBy = 0">Data přidání</div>
                <div class="badge-filter" :class="{'filter-active':orderBy==1}" @click="orderBy = 1">Hodnocení</div>
            </div>
        </div>
        <div class="white_box m-top col-md-11 mx-auto">
            <div v-for="(o,i) in os" class="d-flex justify-content-between align-items-start col-md-10 mx-auto">
                <h5>{{o.fullname}}</h5>
                <div class="d-flex align-items-center">
                    <span style="margin-right:15px">{{formatDate(o.created_at)}}</span>
                    <span style="margin-right:15px">/</span>
                    <span>{{o.score}} <i class="fas fa-star text-danger"></i></span>
                </div>
            </div>
        </div>!-->
        <confirm-offer></confirm-offer>
    </div>
</template>

<script>
    import ConfirmOffer from "./confirm-offer";
    export default {
        name: "confirm-offer-list",
        components: {ConfirmOffer},
        data(){
            return {
                orderBy:0,
                os:[
                    {
                        "fullname":"Vojtěch Voleman",
                        created_at:new Date().getTime(),
                        score:4.8
                    },
                    {
                        "fullname":"Vojtěch Voleman",
                        created_at:new Date().getTime(),
                        score:4.7
                    },
                    {
                        "fullname":"Vojtěch Voleman",
                        created_at:new Date().getTime(),
                        score:4.6
                    },{
                        "fullname":"Vojtěch Voleman",
                        created_at:new Date().getTime(),
                        score:4.5
                    }
                ]
            }
        },
        methods:{
            formatDate(timestamp){
                var d = new Date(timestamp);
                console.log(timestamp);
                return this.fillZero(d.getDate())+"."+this.fillZero(d.getMonth()+1)+"."+d.getFullYear()+" "+this.fillZero(d.getHours())+":"+this.fillZero(d.getMinutes())+":"+this.fillZero(d.getSeconds());
            },
            fillZero(val){
                return ((val < 10) ? "0" : "")+val;
            }
        }
    }
</script>

<style scoped>
    .badge-filter {
        text-align: center;
        background: var(--main-blue);
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 16px;
        margin-left: 5px;
        box-shadow: 0px 0px 10px 0px rgba(214, 214, 214, 1);
        transition: 0.1s;
        cursor: pointer;
        user-select: none;
    }

    .filter-active {
        background: var(--main-orange);
    }

    .badge-filter:not(.filter-active):hover {
        background: var(--main-purple);
    }
</style>
