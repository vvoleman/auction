<template>
    <div v-if="resources.currencies != null"
         class="col-md-8 mx-auto white_box m-top3 d-flex justify-content-between align-items-start flex-wrap">
        <div class="col-12 text-center">
            <h1>Nová nabídka</h1>
            <hr>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Název</label>
                <input type="text" class="form-control" name="name" v-model="inputs.name">
            </div>
            <div class="form-group">
                <label>Typ</label>
                <select class="form-control" name="type" v-model="inputs.type">
                    <option v-for="(o,i) in res.types" :value="o.id_ot">{{o.name}}</option>
                </select>
            </div>
            <div class="form-group">
                <label>Popisek</label>
                <vue-editor v-model="inputs.description" :editor-toolbar="res.customToolbar"/>
                <input type="hidden" name="description" :value="inputs.description">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Kategorie</label>
                <select class="form-control" name="category" v-model="inputs.category">
                    <option v-for="(o,i) in res.categories" :value="o.id_c">{{o.label}}</option>
                </select>
            </div>
            <div class="form-group">
                <label>Doprava</label>
                <select id="delivery" v-model="inputs.delivery" class="form-control" name="delivery">
                    <option v-for="(o,i) in res.deliveries" :value="o.id_dt">{{o.label}}</option>
                </select>
            </div>
            <div class="form-group">
                <label>Typ platby</label>
                <select id="payments" class="form-control" name="payment" v-model="inputs.payment">
                    <option v-for="(o,i) in possiblePays" :value="o.id">{{o.name}}</option>
                </select>
            </div>
            <div class="form-group">
                <label>Měna</label>
                <select class="form-control" name="currency" v-model="inputs.currency">
                    <option value="" v-for="(o,i) in res.currencies" :value="o.id_c">{{o.short}}</option>
                </select>
            </div>
            <div class="form-group">
                <label>Cena</label>
                <input type="number" class="form-control" name="price" v-model="inputs.price">
            </div>
            <div class="form-group">
                <label>Tagy</label>
                <tags @change="tagsChange" v-model="inputs.tags"></tags>
            </div>
            <div class="form-group">
                <label>Obrázky</label>
                <!--<input type="file" multiple="multiple" class="form-control" name="images_upl" @change="fileChanged">
                <gallery :can-remove="false" :files="imgs"></gallery>!-->
            </div>

        </div>
        <button type="submit" class="btn btn-blue btn-block">Přidat</button>
    </div>
</template>

<script>
    import {VueEditor} from "vue2-editor";
    import VueEasyLightbox from 'vue-easy-lightbox'
    import Gallery from "./gallery";
    import Tags from "./tags";

    export default {
        name: "inputs",
        components: {Tags, Gallery, VueEditor, VueEasyLightbox},
        props: ["dat", "res"],
        data() {
            return {
                inputs: {
                    name: this.dat.name,
                    type: this.dat.type,
                    description: this.dat.description,
                    category: this.dat.category,
                    delivery: this.dat.delivery,
                    payment: this.dat.payment,
                    currency: this.dat.currency,
                    price: this.dat.price,
                    tags: this.dat.tags,
                    images: this.dat.images
                },
                resources: {
                    types: this.res.types,
                    categories: this.res.categories,
                    deliveries: this.res.deliveries,
                    payments: this.res.payments,
                    currencies: this.res.currencies,
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
                }

            }
                ;
        },
        mounted() {
            console.log("b");
            this.setInputs();
        },
        methods: {
            tagsChange(tags) {
                this.inputs.tags = tags;
            },
            setInputs() {
                console.log(this.dat.category);
                this.inputs.name = this.dat.name;
                this.inputs.type = this.dat.type;
                this.inputs.description = this.dat.description;
                this.inputs.category = this.dat.category;
                this.inputs.delivery = this.dat.delivery;
                this.inputs.payment = this.dat.payment;
                this.inputs.currency = this.dat.currency;
                this.inputs.price = this.dat.price;
                this.inputs.tags = this.dat.tags;
                this.inputs.images = this.dat.images;
            }
        },
        computed: {
            possiblePays() {
                return null;
                var temp = this.res.payments;
                if (temp != null && temp.length > 0) {
                    var results = temp.filter((x) => {
                        return x.id == this.inputs.delivery;
                    })[0].payments;
                } else {
                    return [];
                }
            },
        },
        watch:{
            dat(){
                console.log("aa");
                this.setInputs();
            }
        }
    }
</script>

<style scoped>

</style>
