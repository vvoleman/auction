<template>
    <div>
        <transition name="fade" mode="out-in">
            <loader key="load" v-if="users.length == 0"></loader>
            <div key="content" v-else>
                <div class="col-md-8 mx-auto">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                        <tr>
                            <td>ID</td>
                            <td>Jméno</td>
                            <td>Přijmení</td>
                            <td>Role</td>
                            <td>Akce</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(o,i) in users">
                            <td>{{o.id_u}}</td>
                            <td>{{o.firstname}}</td>
                            <td>{{o.surname}}</td>
                            <td>{{o.group.name}}</td>
                            <td>
                                <button class="btn-sm btn btn-primary" @click="show_edit = i">Upravit</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <edit-user @close="show_edit = null" @save="saveEdit" v-if="show_edit != null"
                           :g_id="users[show_edit].group.id_g" :g="groups"></edit-user>
            </div>
        </transition>
    </div>
</template>

<script>
    import EditUser from "./EditUser";
    import Loader from "../../sub/Loader";

    export default {
        name: "config-users",
        components: {Loader, EditUser},
        data() {
            return {
                page: 0,
                users: [],
                count: 0,
                show_edit: null,
                groups: []
            }
        },
        mounted() {
            this.getGroups();
            this.getUsers();
        },
        methods: {
            saveEdit(data) {
                this.$snotify.info("Ukládám změny...");
                axios.post('/ajax/admin/editUser', {user_id: this.users[this.show_edit].id_u, group_id: data.group_id})
                    .then((response) => {
                        if (response.data.done) {
                            this.users[this.show_edit].group = response.data.group;
                            this.$snotify.success("Změny byly úspěšně provedeny!");
                        } else {
                            this.$snotify.error("Nebylo možné provést změny!");
                        }
                    })
                    .catch((e) => {
                        this.$snotify.error("Nebylo možné provést změny!");
                    })
                    .then(() => {
                        this.show_edit = null;
                    });
            },
            getGroups() {
                axios.get('/ajax/admin/getGroups')
                    .then((response) => {
                        this.groups = response.data;
                    })
                    .catch((e) => {
                        this.$snotify.error("Nelze načíst data!");
                    })
            },
            getUsers() {
                axios.get('/ajax/admin/getUsers', {params: {page: this.page}})
                    .then((response) => {
                        this.users = response.data.data;
                        this.page = response.data.next;
                        this.count = response.data.count;
                    })
                    .catch((e) => {
                        this.$snotify.error("Nelze načíst data!");
                    });
            }
        }
    }
</script>

<style scoped>

</style>
