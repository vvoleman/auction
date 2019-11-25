<template>
    <div class="col-md-8 mx-auto">
        <div>
            <button style="border-radius:5px 5px 0 0" class="btn btn-success" @click="create_modal = true">Nová kategorie</button>
        </div>
        <div class="d-md-flex flex-wrap">
            <div title="Upravit" @click="setEdited(i)" v-for="(o,i) in categories" class="col-md-6 cat_item"
                 :style="{'background-color': '#'+o.color}">
                <h4>{{o.label}} <i v-if="o.disabled" class="fas fa-lock"></i></h4>
            </div>
        </div>
        <edit-category v-if="edit_modal !== false" :to_edit="current" @close="edit_modal = false"
                       @save="saveEdited"></edit-category>
        <add-category v-if="create_modal" @close="create_modal = false" @save="saveNewCategory"></add-category>
    </div>
</template>

<script>
    import EditCategory from "./EditCategory";
    import AddCategory from "./AddCategory";

    export default {
        name: "CategoriesShower",
        components: {AddCategory, EditCategory},
        props: ["c"],
        data() {
            return {
                edit_modal: false,
                create_modal: false,
                categories: this.c,
                edited: {
                    label: "",
                    description: "",
                    picture: "",
                    color: "",
                    disabled: null
                }
            };
        },
        mounted() {
            console.log("tady");
        },
        methods: {
            setEdited(i) {
                const temp = this.categories[i];
                this.edited.label = temp.label;
                this.edited.description = temp.description;
                this.edited.picture_id = temp.picture_id;
                this.edited.path = temp.path;
                this.edited.color = temp.color;
                this.edit_modal = i;
            },
            saveEdited(data) {
                var cur_pic = this.current.picture_id;
                var id = this.edit_modal;
                this.edit_modal = false;
                if (data.edited_img != null) {
                    this.uploadImage(data.edited_img)
                        .then((response) => {
                            if (response.data.uploaded) {
                                data.picture = response.data.picture_id;
                                this.$snotify.success("Obrázek nahrán!");
                            } else {
                                this.$snotfiy.error("Nebylo možné nahrát obrázek!");
                                data.picture = cur_pic;
                            }
                        })
                        .catch((e) => {
                            this.$snotfiy.error("Nebylo možné nahrát obrázek!");
                            data.picture = cur_pic
                        })
                        .then(() => {
                            this.sendChanges(data, id);
                        });
                } else {
                    data.picture = cur_pic;
                    this.sendChanges(data, id);
                }


            },
            sendChanges(data, id) {
                this.$snotify.info("Odesílám změny...");
                axios.post("/ajax/admin/editCategory", data)
                    .then((response) => {
                        if (response.data.edited) {
                            this.$snotify.success("Kategorie byla změněna!");
                            this.categories = this.categories.splice(id, 1, response.data.category);
                        }
                    })
                    .catch((e) => {
                        this.$snotify.error("Nebylo možné změnit kategorii!");
                        console.log(e);
                    });
            },
            uploadImage(img) {
                const config = {
                    headers: {'content-type': 'multipart/form-data'}
                }
                let formData = new FormData();
                formData.append('image', img);
                return axios.post("/ajax/admin/category/uploadFile", formData, config);
            },
            saveNewCategory(data) {
                this.create_modal = false;
                this.uploadImage(data.img)
                    .then((response) => {
                        if (response.data.uploaded) {
                            this.$snotify.success("Obrázek nahrán!");
                            data.picture_id = response.data.picture_id;
                            this.sendNew(data);
                        } else {
                            this.$snotify.error("Nebylo možné vytvořit kategorii!");
                        }
                    })
                    .catch((e) => {
                        this.$snotify.error("Nebylo možné vytvořit kategorii!");
                    })
            },
            sendNew(data) {
                this.$snotify.info("Vytvářím novou kategorii...");
                axios.post("/ajax/admin/newCategory", data)
                    .then((response) => {
                        this.categories.push(response.data.category);
                        this.$snotify.success("Kategorie úspěšně přidána!");
                    })
                    .catch(() => {
                        this.$snotify.error("Nebylo možné přidat kategorii!");
                    });
            }
        },
        computed: {
            current() {
                return (this.edit_modal === false) ? null : this.categories[this.edit_modal];
            },
        },
        watch: {
            c() {
                this.categories = this.c;
            }
        }
    }
</script>

<style scoped>
    .cat_item {
        padding: 15px;
        text-align: center;
        cursor: pointer;
        user-select: none;
    }

    .cat_item h4 {
        color: white;
    }
</style>
