<template>
        <modal @save="saveEdited" style="width: 80%;height: 90%;" @close="close">
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
</template>

<script>
    import ImagePreview from "./ImagePreview";
    export default {
        name: "EditCategory",
        components: {ImagePreview},
        props:["to_edit"],
        data(){
            return {
                label:"",
                description:"",
                picture:"",
                color:"",
                disabled:null,
                picture_id:null,
                path:"",
                edited_img:""
            }
        },
        mounted(){
            this.setEdited(this.to_edit);
        },
        methods:{
            setEdited(data){
                console.log(data);
                this.label = data.label;
                this.description = data.description;
                this.picture_id = data.picture_id;
                this.path = data.path;
                this.color = data.color;
                this.disabled = data.disabled;
                this.edited_img = null;
            },
            saveEdited(){
                this.$emit("save",this.res);
            },
            close(){
                this.$emit("close",this.res);
            },
            imgChange(data){
                if(data !== false){
                    this.edited_img = data;
                }
            }
        },
        watch:{
            to_edit(){
                this.setEdited(this.to_edit);
            }
        },
        computed:{
            res(){
                return {
                    label:this.label,
                    description:this.description,
                    picture:this.picture,
                    color:this.color,
                    disabled:(this.disabled == null) ? false : this.disabled,
                    uuid:this.to_edit.uuid,
                    edited_img:this.edited_img
                }
            }
        }
    }
</script>

<style scoped>

</style>
