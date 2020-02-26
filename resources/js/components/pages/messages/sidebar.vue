<template>
    <div class="sidebar">
        <div class="upper d-flex justify-content-between align-items-center col-12 mx-auto sticky-top">
            <div class="h">Chaty</div>
            <i @click="new_msg = true" class="fas fa-edit new-message"></i>
        </div>
        <modal v-if="new_msg">
            <div slot="header"><h3>Nová zpráva</h3></div>
            <div slot="body">
                <div class="col-md-6 mx-auto">
                    <div class="form-group">
                        <label>Jméno</label>
                        <v-select @search="load"></v-select>
                    </div>
                    <div class="form-group">
                        <label>Zpráva</label>
                        <textarea class="form-control" style="height: 30vh"></textarea>
                    </div>
                </div>
            </div>
            <div slot="footer">
                <button class="btn btn-danger" @click="closeNewMsg">Zavřít</button>
                <button class="btn btn-success" @click="sendNewMsg">Odeslat</button>
            </div>
        </modal>
        <div class="m-top search-input">
            <input @keydown.esc="search = ''" v-model="search" type="text" autocomplete="off" class="col-12 mx-auto">
        </div>
        <hr>
        <div class="contacts">
            <div v-for="(o,i) in contacts_filtered" class="contact d-flex justify-content-between">
                <div class="d-flex">
                    <div class="img_bubble" :style="{'background-image':'url('+o.img+')'}"></div>
                    <div class="m-left">
                        <div class="name">{{o.name}}</div>
                        <div class="second">{{o.text}}</div>
                    </div>
                </div>
                <div><span class="second">22.2</span></div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "sidebar",
        data(){
            return {
                new_msg:false,
                contacts:[
                    {
                        name:"Marco",
                        text:"Text ot ofjsajk",
                        img:"https://www.aldergrovestar.com/wp-content/uploads/2019/07/17649457_web1_raccoon-pic-GPS.jpg"
                    },
                    {
                        name:"Memo",
                        text:"Text ot ofjsajk",
                        img:"https://www.nwf.org/-/media/NEW-WEBSITE/Shared-Folder/Wildlife/Mammals/mammal_raccoon-wisconsin_mary-braatz_600x300.ashx"
                    },
                    {
                        name:"Marco",
                        text:"Text ot ofjsajk",
                        img:"https://curiodyssey.org/wp-content/uploads/bb-plugin/cache/xMammals-Raccoon-square.jpg.pagespeed.ic.W5-0FMTZBa.jpg"
                    },
                    {
                        name:"Tet",
                        text:"Text ot ofjsajk",
                        img:"https://www.aldergrovestar.com/wp-content/uploads/2019/07/17649457_web1_raccoon-pic-GPS.jpg"
                    },
                    {
                        name:"Marco",
                        text:"Text ot ofjsajk",
                        img:"https://www.nwf.org/-/media/NEW-WEBSITE/Shared-Folder/Wildlife/Mammals/mammal_raccoon-wisconsin_mary-braatz_600x300.ashx"
                    },
                    {
                        name:"Marco",
                        text:"Text ot ofjsajk",
                        img:"https://curiodyssey.org/wp-content/uploads/bb-plugin/cache/xMammals-Raccoon-square.jpg.pagespeed.ic.W5-0FMTZBa.jpg"
                    },
                    {
                        name:"Marco",
                        text:"Text ot ofjsajk",
                        img:"https://www.aldergrovestar.com/wp-content/uploads/2019/07/17649457_web1_raccoon-pic-GPS.jpg"
                    },
                    {
                        name:"Marco",
                        text:"Text ot ofjsajk",
                        img:"https://www.nwf.org/-/media/NEW-WEBSITE/Shared-Folder/Wildlife/Mammals/mammal_raccoon-wisconsin_mary-braatz_600x300.ashx"
                    },
                    {
                        name:"Marco",
                        text:"Text ot ofjsajk",
                        img:"https://curiodyssey.org/wp-content/uploads/bb-plugin/cache/xMammals-Raccoon-square.jpg.pagespeed.ic.W5-0FMTZBa.jpg"
                    },
                    {
                        name:"Marco",
                        text:"Text ot ofjsajk",
                        img:"https://www.aldergrovestar.com/wp-content/uploads/2019/07/17649457_web1_raccoon-pic-GPS.jpg"
                    },
                    {
                        name:"Marco",
                        text:"Text ot ofjsajk",
                        img:"https://www.nwf.org/-/media/NEW-WEBSITE/Shared-Folder/Wildlife/Mammals/mammal_raccoon-wisconsin_mary-braatz_600x300.ashx"
                    },
                    {
                        name:"Marco",
                        text:"Text ot ofjsajk",
                        img:"https://curiodyssey.org/wp-content/uploads/bb-plugin/cache/xMammals-Raccoon-square.jpg.pagespeed.ic.W5-0FMTZBa.jpg"
                    }
                ],
                search:"",
                msg:""
            }
        },
        computed:{
            contacts_filtered(){
                return this.contacts.filter((x)=>{return x.name.toLowerCase().indexOf(this.search) != -1});
            }
        },
        methods:{
            closeNewMsg(){
                this.new_msg = false;
                this.msg = "";
            },
            load(search,loading){
                loading(true);
                setTimeout(()=>{loading(false)},500);
            }
        }
    }
</script>

<style scoped>
    .img_bubble{
        background-position: center;
        background-size:cover;
        width:50px;
        height:50px;
        border:2px solid #888;
    }
    .upper{
        padding:10px;
        background:#f9f9f9;
        border-bottom:1px solid #dfdfdf;
    }
    .sidebar{
        background:#f9f9f9;
        position:absolute;
        height:90vh;
        overflow:auto;
    }
    .contact{
        margin:20px 0;
    }
    .search-input input{
        border:1px solid #dfdfdf;
        border-radius:5px;
        background: #f0f0f0;
        padding:8px 1px;
        height:40px;
    }
    .search-input button{
        height:40px;
        border-top-left-radius:0px;
        border-bottom-left-radius:0px;
    }
    .upper .h{
        font-size:25px;
        font-weight: bold;
    }
    .new-message{
        font-size:22px;
        padding:10px;
        border-radius:100%;
        transition:0.2s;
        cursor:pointer;
    }
    .new-message:hover{
        background:#e9e9e9;
    }
    .contact{
        padding:0 2px;
    }
    .contact .name{
        color:black;
    }
    .contact .second{
        font-size:15px;
        color:#aaa;
    }
    ::-webkit-scrollbar-track{
        background: transparent;
        border-right: 1px solid #dfdfdf;
    }
</style>
