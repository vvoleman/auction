<template>
    <div class="white_box m-top">
        <h1 class="text-center">Správa obrázků</h1>
        <hr class="col-md-6 mx-auto">

        <div class="col-12">
            <div class="d-flex align-items-baseline justify-content-between">
                <label class="fileContainer">
                    <button :disabled="img_urls.length >= max" class="btn btn-primary"><i class="fas fa-upload"></i> Přidat
                        obrázek
                    </button>
                    <input :title="(img_urls.length >= max) ? 'Nelze nahrát obrázek!' : ''" :disabled="img_urls.length >= max" @change="imageFile" type="file"/>
                </label>
                <div class="d-flex align-items-center">
                    <button :disabled="!anychange" class="btn btn-danger" @click="cancel">Zrušit</button>
                    <button :disabled="!anychange || over_limit" class="btn btn-success m-left" @click="uploadImages">Uložit</button>
                    <div class="badge m-left"
                         :class="{'badge-danger':over_limit,'badge-success':!over_limit}">{{img_urls.length}}/{{max}}
                    </div>
                </div>
            </div>
            <gallery @remove="removeImage" :can-remove="true" :files="img_urls"></gallery>
        </div>
    </div>
</template>

<script>
    export default {
        name: "edit-images",
        props:['token','images'],
        data() {
            return {
                imgs: [],
                og:[],
                uploaded: [],
                uploaded_urls: [],
                max: 5
            }
        },
        mounted(){
          var temp = JSON.parse(this.images);
          this.reset(temp);
        },
        methods: {
            removeImage(i) {
                var ex_length = this.imgs.length - 1;
                if(ex_length >= i){
                    this.imgs.splice(i,1);
                }else{
                    var temp = i-ex_length-1;
                    console.log(temp);
                    this.uploaded.splice(temp,1);
                    console.log(this.uploaded);
                    this.uploaded_urls.splice(temp,1);
                }
            },
            uploadImages(){
                if(!confirm('Opravdu chcete uložit?')) return;

                let formData = new FormData();
                formData.append("uuid",this.token);
                for(var i=0;i<this.uploaded.length;i++){
                    formData.append('image[]',this.uploaded[i]);
                }
                for(var i=0;i<this.imgs.length;i++){
                    formData.append('existing[]',this.imgs[i].id);
                }

                axios.post("/ajax/offers/updateImages",formData)
                    .then((response)=>{
                        if(response.data.status == 200){
                            this.reset(response.data.data);
                            this.$snotify.success(response.data.message);
                        }else{
                            this.$snotify.error(response.data.message);
                        }

                    })
                    .catch((error)=>{
                        this.$snotify.error("Vyskytla se chyba!");
                    })
            },
            reset(data){
                this.imgs = data.slice();
                this.og = data.slice();
                this.uploaded = [];
                this.uploaded_urls = [];
            },
            imageFile(data) {
                var temp = data.target.files[0];
                if (temp != null) {
                    var msg;
                    if (this._isTypeOk(temp.type)) {
                        if (temp.size <= 64000000) {
                            this.uploaded.push(temp);
                            this.addUploadedUrl(temp);
                            return;
                        } else {
                            msg = "Maximální velikost obrázku je 8MB!";
                        }
                    } else {
                        msg = "Neplatný formát obrázku!";
                    }
                    this.$snotify.error(msg);
                }
            },
            addUploadedUrl(file) {
                var reader;
                reader = new FileReader();
                reader.onload = (e) => {
                    this.uploaded_urls.push(e.target.result);
                }
                reader.readAsDataURL(file);
            },
            cancel(){
              if(confirm("Opravdu si přejete smazat změny?")){
                  this.imgs = this.og.slice();
                  this.uploaded = [];
                  this.uploaded_urls = [];
              }
            },
            _isTypeOk(type) {
                const supported = ["image/png", "image/jpg", "image/jpeg", "image/gif"];
                return supported.includes(type);
            }
        },
        computed: {
            img_urls() {
                return this.imgs.map((x) => {
                    return x.url;
                }).concat(this.uploaded_urls);
            },
            over_limit() {
                var length = this.img_urls.length;
                return length > this.max || length == 0;
            },
            anychange(){
                return !_.isEqual(this.og,this.imgs) || this.uploaded_urls.length > 0;
            }
        }

    }
</script>

<style scoped>
    .m-left{
        margin-left:5px;
    }
    .badge {
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 17px;
        font-weight: normal;
    }

    .fileContainer {
        overflow: hidden;
        position: relative;
    }

    .fileContainer [type=file] {
        cursor: inherit;
        display: block;
        font-size: 999px;
        filter: alpha(opacity=0);
        min-height: 100%;
        min-width: 100%;
        opacity: 0;
        position: absolute;
        right: 0;
        text-align: right;
        top: 0;
    }
</style>
