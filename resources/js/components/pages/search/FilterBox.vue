<template>
    <div class="flex-wrap">
        <div class="col-md-4">
            <label>Cena</label>
            <div class="d-flex">
                <input placeholder="Od" class="form-control" v-model="min" type="number">
                <input placeholder="Do" class="form-control" v-model="max" type="number">
            </div>
        </div>
        <div class="col-md-4 form-group">
            <label>Kategorie</label>
            <select class="form-control" v-model="selected_category">
                <option value="null">---</option>
                <option v-for="(o,i) in categories" :value="o.id" :key="i">{{o.name}}</option>
            </select>
        </div>
        <div class="col-md-4 form-group">
            <label>Typ nabídky</label>
            <select class="form-control" v-model="selected_type">
                <option value="null">---</option>
                <option v-for="(o,i) in types" :value="o.id" :key="i">{{o.name}}</option>
            </select>
        </div>
        <div class="col-md-4 form-group">
            <label>Měna</label>
            <select class="form-control" v-model="selected_currency">
                <option value="null">---</option>
                <option v-for="(o,i) in currencies" :value="o.id" :key="i">{{o.name}}</option>
            </select>
        </div>
        <div class="col-md-4 form-group">
            <label>Země</label>
            <select class="form-control" v-model="selected_country">
                <option value="null">---</option>
                <option v-for="(o,i) in countries" :value="o.id" :key="i">{{o.name}}</option>
            </select>
        </div>
        <div class="col-md-4 form-group">
            <label>Kraj</label>
            <select class="form-control" v-model="selected_region">
                <option value="null">---</option>
                <option v-for="(o,i) in regions[selected_country]" :value="o.id" :key="i">{{o.name}}</option>
            </select>
        </div>
    </div>
</template>

<script>
    export default {
        name: "FilterBox",
        props: {
            boot: {
                required: true
            }
        },
        data() {
            return {
                dirty: false,
                min: null,
                max: null,
                types: [],
                currencies: [],
                categories:[],
                countries: [],
                regions: {},
                selected_type: null,
                selected_currency: null,
                selected_country: null,
                selected_region: null,
                selected_category:null,
            }
        },
        mounted() {
            this._setBoot();
            this.emitData();
        },

        methods: {
            _setBoot() {
                var temp = JSON.parse(this.boot);
                this.min = parseFloat(temp.min);
                this.max = parseFloat(temp.max);
                this.types = temp.types;
                this.currencies = temp.currencies;
                this.countries = temp.countries;
                this.regions = temp.regions;
                this.categories = temp.categories;
            },
            emitData() {
                this.$emit("changed", {
                    price: this.searchForNull(this.price),
                    type: this.searchForNull(this.selected_type),
                    currency: this.searchForNull(this.selected_currency),
                    country: this.searchForNull(this.selected_country),
                    region: this.searchForNull(this.selected_region),
                    category: this.searchForNull(this.selected_category),
                });
                this.dirty = false;
            },
            searchForNull(str) {
                return (str == "null") ? null : str;
            }
        },
        watch: {
            country() {
                this.selected_region = null;
            },
            selected_type() {
                this.emitData()
            },
            selected_currency() {
                this.emitData()
            },
            selected_country() {
                this.emitData()
            },
            selected_region() {
                this.emitData()
            },
            selected_category() {
                this.emitData()
            },
        },
        computed: {
            country() {
                return this.selected_country;
            },
            price(ff) {
                if (this.min != null && this.max != null) {
                    if(this.min < 0){
                        this.min = 0;
                    }
                    if(this.max < 0){
                        this.max = 0;
                    }
                    if (this.min > this.max) {
                        alert("Neplatný input");
                    }
                }
                return [this.min, this.max];
            }
        }

    }
</script>

<style scoped>

</style>
