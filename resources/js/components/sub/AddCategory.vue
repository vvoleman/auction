<template>
    <div>
        <modal @save="save" style="width: 80%;height: 90%;" @close="close">
            <div slot="header">Upravení kategorie</div>
            <div slot="body">
                <div class="d-flex flex-wrap">
                    <div class="col-md-6 form-group">
                        <label>Název</label>
                        <input v-model="label" type="text" class="form-control">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Popis</label>
                        <textarea v-model="description" class="form-control"></textarea>
                    </div>
                    <div class="col-md-6 form-group">
                        <image-preview :img="path" @changed="imgChange"></image-preview>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Barva</label>
                        <input v-model="color" type="text" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="d-block">Vypnuto</label>
                        <label class="switch">
                            <input v-model="disabled" type="checkbox">
                            <span class="slider round d-block"></span>
                        </label>
                    </div>
                </div>
            </div>
        </modal>
    </div>
</template>

<script>
    import ImagePreview from "./ImagePreview";
    export default {
        name: "AddCategory",
        components: {ImagePreview},
        data(){
            return {
                label:"",
                description:"",
                color:"",
                disabled:null,
                path:"",
                img:""
            }
        },
        methods:{
            close(){
                this.$emit("close");
            },
            save(){
                this.$emit("save",this.res);
            },
            imgChange(data){
                if(data !== false){
                    this.img = data;
                }
            }
        },
        computed:{
            res(){
                return {
                    label:this.label,
                    description:this.description,
                    color:this.color,
                    disabled:(this.disabled == null) ? false : this.disabled,
                    img:this.img
                }
            }
        }
    }
</script>

<style scoped>

</style>
