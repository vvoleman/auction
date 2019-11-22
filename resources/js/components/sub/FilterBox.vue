<template>
    <div class="d-flex flex-wrap">
        <div class="col-md-4">
            <label>Cena</label>
            <slider :min="(isPriceSame) ? null : price[0]" :max="(isPriceSame) ? null : price[1]" v-model="price" class="form-control" :tooltip="'focus'"></slider>
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
        props:{
            boot:{
                required:true
            }
        },
        data(){
            return {
                dirty:false,
                price:[],
                types:[],
                currencies:[],
                countries:[],
                regions:{},
                selected_type:null,
                selected_currency:null,
                selected_country:null,
                selected_region:null,
            }
        },
        mounted(){
            this._setBoot();
            this.emitData();
        },

        methods:{
            _setBoot(){
                var temp = JSON.parse(this.boot);
                this.price = [parseFloat(temp.min),parseFloat(temp.max)];
                this.types = temp.types;
                this.currencies = temp.currencies;
                this.countries = temp.countries;
                this.regions = temp.regions;
            },
            emitData(){
                this.$emit("changed",{
                    price:this.searchForNull(this.price),
                    type:this.searchForNull(this.selected_type),
                    currency:this.searchForNull(this.selected_currency),
                    country:this.searchForNull(this.selected_country),
                    region:this.searchForNull(this.selected_region)
                });
                this.dirty = false;
            },
            searchForNull(str){
                return (str == "null") ? null : str;
            }
        },
        watch:{
            country(){
                this.selected_region = null;
            },
            selected_type(){this.emitData()},
            selected_currency(){this.emitData()},
            selected_country(){this.emitData()},
            selected_region(){this.emitData()},
        },
        computed:{
            isPriceSame(){
                return this.price.length == 1;
            },
            country(){
                return this.selected_country;
            }
        }

    }
</script>

<style scoped>

</style>
