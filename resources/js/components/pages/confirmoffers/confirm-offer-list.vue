<template>
    <div class="col-md-6 mx-auto">
        <div class="white_box m-top3 text-center">
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
        <div class="white_box link m-top col-md-11 mx-auto">
            <a :href="o.url" v-for="(o,i) in ordered">
                <div class="d-flex justify-content-between align-items-start col-md-10 mx-auto">
                    <div class="d-flex align-items-start">
                        <span style="margin-right:15px">{{i+1}}</span>
                        <h5>{{o.fullname}}</h5>
                    </div>
                    <div class="d-flex align-items-center">
                        <span style="margin-right:15px">{{formatDate(o.created_at)}}</span>
                        <span style="margin-right:15px">/</span>
                        <span>{{o.score}} <i class="fas fa-star text-danger"></i></span>
                    </div>
                </div>
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        name: "confirm-offer-list",
        props:['dat'],
        data(){
            return {
                orderBy:0,
                os:[]
            }
        },
        mounted(){
            this.os = JSON.parse(this.dat);
        },
        methods:{
            formatDate(timestamp){
                var d = new Date(timestamp*1000);
                return this.fillZero(d.getDate())+"."+this.fillZero(d.getMonth()+1)+"."+d.getFullYear()+" "+this.fillZero(d.getHours())+":"+this.fillZero(d.getMinutes())+":"+this.fillZero(d.getSeconds());
            },
            fillZero(val){
                return ((val < 10) ? "0" : "")+val;
            }
        },
        computed:{
            ordered(){
                //0 = datum
                //1 = hodnocení
                if(this.orderBy == 0){
                    return this.os.sort((a,b)=>{(a.created_at > b.created_at) ? 1 : -1});
                }
                return this.os.sort((a,b)=>{(a.score > b.score) ? 1 : -1});
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
    .white_box a{
        color:inherit;
    }
    .white_box a:hover{
        text-decoration: none;
    }
    .link{
        transition: 0.1s;
    }
    .link:hover{
        background-color: #f6f6f6;
    }
</style>
