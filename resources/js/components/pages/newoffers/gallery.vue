<template>
    <div>
        <vue-easy-lightbox
                :visible="visible"
                :imgs="imgs"
                :index="index"
                @hide="visible = false"
        ></vue-easy-lightbox>
        <div class="col-12 mx-auto d-flex flex-wrap">
            <div class="img_bg" v-for="(o,i) in imgs" :style="{'background-image':'url('+o+')'}">
                <transition name="fade">
                    <div class="mask">
                        <i v-if="canRemove" class="far fa-times-circle" @click="remove(i)"></i>
                        <i class="fas fa-eye" @click="openGallery(i)"></i>
                    </div>
                </transition>
            </div>
        </div>
    </div>
</template>

<script>
    import VueEasyLightbox from 'vue-easy-lightbox'

    export default {
        name: "gallery",
        props: {
            files: {
                default: () => {
                    return []
                }
            },
            'can-remove': {
                type:Boolean
            }
        },
        components: {VueEasyLightbox},
        data() {
            return {
                visible: false,
                imgs: [
                    /*"https://i.imgur.com/PXLtrrh.jpg",
                    "http://i.imgur.com/9IiNASg.jpg",
                    "https://nexus.leagueoflegends.com/wp-content/uploads/2019/12/PoroKingheader_drnts00qclis46u1fcy4.png",
                    "https://lan.leagueoflegends.com/sites/default/files/styles/scale_xlarge/public/upload/ask_riot_poro_king.jpg?itok=qhoh9dbv",
                    "https://eune.leagueoflegends.com/sites/default/files/styles/wide_medium/public/upload/porowrap_articlebanner.jpg?itok=MFyb1Wxz",
                    "https://pbs.twimg.com/profile_images/1140105095352389632/ERZWqRuu.png",
                    "https://ddragon.leagueoflegends.com/cdn/img/champion/splash/Teemo_5.jpg",
                    "https://steamuserimages-a.akamaihd.net/ugc/778487244664649833/C42C898211719D010E99F2F65D8893D64A5B0013/?imw=637&imh=358&ima=fit&impolicy=Letterbox&imcolor=%23000000&letterbox=true",
                    "https://i.redd.it/poq45h3orat31.jpg",
                    "https://notagamer.net/wp-content/uploads/2019/11/image-93.png",
                    "https://i.ytimg.com/vi/HRHbUVTuosQ/maxresdefault.jpg"*/
                ],
                index: 0
            }
        },
        mounted() {
            this.filesToImgs();
        },
        methods: {
            remove(i) {
                this.$emit("remove", i);
            },
            filesToImgs() {
                this.imgs = this.files.map((x) => {
                    return x
                });
            },
            openGallery(i) {
                this.index = i;
                this.visible = true;
            }
        },
        watch: {
            files() {
                this.filesToImgs();
            }
        }
    }
</script>

<style scoped>
    .mask {
        position: relative;
        background: rgba(0, 0, 0, 0.8);
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        display: none;
        transition: 0.1s;
    }

    .img_bg:hover .mask {
        display: flex;
    }

    .img_bg {
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        width: 80px;
        height: 80px;
        margin: 5px;
    }

    .img_bg i {
        font-size: 20px;
        margin: 5px;
        color: var(--main-orange);
    }
</style>
