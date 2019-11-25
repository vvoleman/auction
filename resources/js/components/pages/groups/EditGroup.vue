<template>
    <div class="col-12 main">
        <div class="col-md-8 mx-auto m-top2">
            <div class="form-group row align-items-center">
                <label for="staticEmail" class="col-form-label bigger">Název</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="staticEmail">
                </div>
            </div>
            <div class="row col-12 m-top3 justify-content-center">
                <span class="bigger d-block">Oprávnění</span>
                <manage-perms></manage-perms>
            </div>
        </div>
    </div>
</template>

<script>
    import ManagePerms from "./ManagePerms";
    export default {
        name: "EditGroup",
        components: {ManagePerms}
    }
</script>

<style scoped>
    .main{
        margin-top:0;
        margin-bottom:0;
    }
    .bigger{
        font-size:25px;
    }
</style>
