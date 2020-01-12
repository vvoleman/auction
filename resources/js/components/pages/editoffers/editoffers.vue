<template>
    <div v-if="obj != null"
         class="col-md-8 mx-auto white_box m-top3 d-flex justify-content-between align-items-start flex-wrap">
        <div class="col-12 text-center">
            <h1>Upravit nabídku</h1>
            <hr>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Název</label>
                <input type="text" class="form-control" name="name" :value="obj.name">
            </div>
            <div class="form-group">
                <label>Typ</label>
                <select class="form-control" disabled>
                    <option>{{obj.type}}</option>
                </select>
            </div>
            <div class="form-group">
                <label>Popisek</label>
                <vue-editor v-model="description" :editor-toolbar="customToolbar"/>
                <input type="hidden" name="description" :value="description">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Kategorie</label>
                <select class="form-control" disabled>
                    <option>{{obj.category}}</option>
                </select>
            </div>
            <div class="form-group">
                <label>Doprava</label>
                <select class="form-control" disabled>
                    <option>{{obj.delivery}}</option>
                </select>
            </div>
            <div class="form-group">
                <label>Typ platby</label>
                <select class="form-control" disabled>
                    <option>{{obj.payment}}</option>
                </select>
            </div>
            <div class="form-group">
                <label>Měna</label>
                <select class="form-control" name="currency" disabled>
                    <option>{{obj.currency}}</option>
                </select>
            </div>
            <div class="form-group">
                <label>Cena</label>
                <input type="number" class="form-control" :value="obj.price" disabled>
            </div>
            <div class="form-group">
                <label>Tagy</label>
                <tags @change="tagsChange" :t="tags"></tags>
            </div>

        </div>
        <input type="hidden" name="_tags" id="_tags" :value="compileTags">
        <button type="submit" class="btn btn-blue btn-block">Přidat</button>
    </div>
</template>

<script>
    import Tags from "../newoffers/tags";
    import {VueEditor} from "vue2-editor";

    export default {
        name: "editoffers",
        components: {Tags, VueEditor},
        props: ['dat'],
        data() {
            return {
                tags: [],
                obj: null,
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
                description:""
            }
        },
        mounted() {
            this.obj = JSON.parse(this.dat);
            this.description = this.obj.description;
            this.tags = this.obj.tags;
        },
        methods:{
            tagsChange(tags){
                this.tags = tags;
            }
        },
        computed:{
            compileTags(){
                return JSON.stringify(this.tags);
            }
        }
    }
</script>

<style scoped>

</style>
