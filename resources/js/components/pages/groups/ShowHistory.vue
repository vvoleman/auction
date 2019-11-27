<template>
    <div>
        <modal>
            <div slot="header">Historie úprav u skupiny</div>
            <div slot="body">
                <transition name="fade" mode="out-in">
                    <loader key="load" v-if="!loaded"></loader>
                    <div key="content" v-if="loaded && results.length > 0">
                        <table class="table col-md-8 mx-auto">
                            <thead class="thead-dark">
                                <tr>
                                    <td>Datum</td>
                                    <td>Změna</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(o,i) in results" :class="{'green':!o.deleted,'red':o.deleted}">
                                    <td>{{formatDate(o.date)}}</td>
                                    <td>{{o.text}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div key="nodata" v-if="loaded && results.length == 0"><h4 class="text-muted text-center">Žádná data nenalezena</h4></div>
                </transition>
            </div>
            <div slot="footer">
                <button class="btn btn-danger" @click="close">Zavřít</button>
            </div>
        </modal>
    </div>
</template>

<script>
    import Loader from "../../sub/Loader";
    export default {
        name: "ShowHistory",
        components: {Loader},
        props:["group_id"],
        data(){
            return {
                results:[],
                loaded:false
            }
        },
        mounted(){
            this.loadResults();
        },
        methods:{
            loadResults(){
                axios.get('/ajax/admin/getGroupHistory',{params:{group_id:this.group_id}})
                    .then((response)=>{
                        this.results = response.data;
                    })
                    .catch((e)=>{
                        this.$snotify.error("Nelze načíst data!");
                        this.close();
                    })
                    .then(()=>{
                       this.loaded = true;
                    });
            },
            formatDate(timestamp){
                var d = new Date(timestamp*1000);
                return this.fillZero(d.getDay())+"."+this.fillZero(d.getMonth())+"."+d.getFullYear()+" "+this.fillZero(d.getHours())+":"+this.fillZero(d.getMinutes())+":"+this.fillZero(d.getSeconds());
            },
            close(){
                this.$emit("close");
            },
            fillZero(val){
                return ((val < 10) ? "0" : "")+val;
            }
        }
    }
</script>

<style scoped>
    .green{
        background: #76c47d;
    }
    .red{
        background: #c45c58;
    }
</style>
