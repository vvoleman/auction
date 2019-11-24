<template>
    <div>
        <div class="form-group">
            <div>
                <label>Obrázek</label>
                <button v-if="img != image" @click="image = img">Zrušit</button>
            </div>
            <input type="file" @change="onFileChange" class="form-control">
            <img :src="image" class="col-md-4 mx-auto">
        </div>
    </div>
</template>

<script>
    export default {
        name: "ImagePreview",
        props: ["img"],
        data() {
            return {
                image: this.img,
            };
        },
        methods: {
            onFileChange(e) {
                const file = e.target.files[0];
                this.image = URL.createObjectURL(file);
                this.$emit("changed", (this.image != this.img) ? file : false);
            }
        },
        watch: {
            img() {
                this.image = this.img;
            }
        }
    }
</script>

<style scoped>

</style>
