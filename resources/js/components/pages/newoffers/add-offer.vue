<template>
    <div v-if="curr != null" class="col-md-8 mx-auto white_box m-top3 d-flex justify-content-between align-items-start flex-wrap">
        <div class="col-12 text-center">
            <h1>Nová nabídka</h1>
            <hr>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Název</label>
                <input type="text" class="form-control" name="name">
            </div>
            <div class="form-group">
                <label>Typ</label>
                <select class="form-control" name="type">
                    <option v-for="(o,i) in types" :value="o.id_ot">{{o.name}}</option>
                </select>
            </div>
            <div class="form-group">
                <label>Popisek</label>
                <vue-editor v-model="content" :editor-toolbar="customToolbar"/>
                <input type="hidden" name="description" :value="content">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Kategorie</label>
                <select class="form-control" name="category">
                    <option v-for="(o,i) in categories" :value="o.id_c">{{o.label}}</option>
                </select>
            </div>
            <div class="form-group">
                <label>Doprava</label>
                <select id="delivery" v-model="del_sel" class="form-control" name="delivery">
                    <option v-for="(o,i) in deliveries" :value="o.id_dt">{{o.label}}</option>
                </select>
            </div>
            <div class="form-group">
                <label>Typ platby</label>
                <select id="payments" class="form-control" name="payment">
                    <option v-for="(o,i) in possiblePays" :value="o.id">{{o.name}}</option>
                </select>
            </div>
            <div class="form-group">
                <label>Měna</label>
                <select class="form-control" name="currency" v-model="curr.selected">
                    <option value="" v-for="(o,i) in curr.all" :value="o.id_c">{{o.short}}</option>
                </select>
            </div>
            <div class="form-group">
                <label>Cena</label>
                <input type="number" class="form-control" name="price">
            </div>
            <div class="form-group">
                <label>Tagy</label>
                <tags @change="tagsChange"></tags>
            </div>
            <div class="form-group">
                <label>Obrázky</label>
                <input type="file" multiple="multiple" class="form-control" name="images_upl[]" @change="fileChanged">
                <gallery :can-remove="false" :files="imgs"></gallery>
            </div>

        </div>
        <input type="hidden" name="_tags" id="_tags" :value="compileTags">
        <button type="submit" class="btn btn-blue btn-block">Přidat</button>
    </div>
</template>

<script>
    import {VueEditor} from "vue2-editor";
    import VueEasyLightbox from 'vue-easy-lightbox'
    import Gallery from "./gallery";
    import Tags from "./tags";

    export default {
        name: "add-offer",
        components: {Tags, Gallery, VueEditor, VueEasyLightbox},
        props:["dat"],
        data() {
            return {
                files: null,
                content: "",
                customToolbar: [
                    [{'header': [false, 1, 2, 3, 4, 5, 6,]}],
                    [{'size': ['small', false, 'large', 'huge']}],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{'align': ''}, {'align': 'center'}, {'align': 'right'}, {'align': 'justify'}],
                    ['blockquote'],
                    [{'list': 'ordered'}, {'list': 'bullet'}, {'list': 'check'}],
                    [{'indent': '-1'}, {'indent': '+1'}],
                    [{'color': []}, {'background': []}],
                    ['link'],
                    [{'direction': 'rtl'}],
                    ['clean'],
                ],
                imgs: [
                ],
                visible: false,
                types:[],
                curr:null,
                deliveries:[],
                payments:[],
                categories:[],
                del_sel:0,
                tags:[]
            }
        },
        mounted(){
            var temp = JSON.parse(this.dat);
            this.types = temp.types;
            this.curr = temp.curr;
            this.deliveries = temp.deliveries;
            this.payments = temp.payments;
            this.categories = temp.categories;
            this.del_sel = this.deliveries[0].id_dt;
        },
        beforeDestroy() {
            // Always destroy your editor instance when it's no longer needed
            this.editor.destroy()
        },
        methods: {
            fileChanged(data) {
                var temp = data.target.files;
                this.files = data.target.files;
                if(temp.length > 5){
                    this.$snotify.error(`Můžete nahrát maximálně 5 obrázků!`);
                    return;
                }
                this.imgs = [];
                for (var i = 0; i < temp.length; i++) {
                    this.addFile(temp[i]);
                }
            },
            addFile(file){
                var reader = new FileReader();
                reader.onload = (e) => {
                    if (e.total > 5000000) {
                        this.$snotify.error(`Obrázek "${temp[i].name}" je moc velký!`);
                    } else {
                        this.imgs.push(e.target.result);
                    }
                }
                reader.readAsDataURL(file);
            },
            removeImage(i){
                this.imgs.splice(i,1);
            },
            tagsChange(tags){
                this.tags = tags;
            }
        },
        computed:{
            possiblePays(){
                var temp = this.payments;
                if(temp != null && temp.length > 0) {
                    return temp.filter((x) => {
                        return x.id == this.del_sel;
                    })[0].payments;
                }else{
                    return [];
                }
            },
            compileTags(){
                return JSON.stringify(this.tags);
            }
        }
    }
</script>

<style scoped>

</style>
