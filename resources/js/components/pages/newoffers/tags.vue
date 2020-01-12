<template>
    <div>
        <input v-model="input" v-on:keydown.enter.prevent="add" autocomplete="off" type="text" class="form-control">
        <transition name="fade">
            <div v-if="error" class="error">
                Prosím, zadejte pouze slova a písmena!
            </div>
        </transition>
        <div class="tags" id="tag_container">
            <div class="tag" v-for="(o,i) in tags" @click="remove(i)">
                {{o}}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "tags",
        props:{
            t:{
                type:Array,
                default:()=>{return [];}
            }
        },
        data() {
            return {
                tags: this.t,
                error: false,
                input: ""
            }
        },
        methods: {
            add(e) {
                if (/^[a-zA-Z0-9., ]+$/.test(this.input)) {
                    if(this.tags.includes(this.input)){
                        return;
                    }
                    this.tags.push(this.input);
                    this.input = "";
                } else {
                    this.error = true;
                    setTimeout(() => {
                        this.error = false
                    }, 2000)
                }
            },
            remove(i){
                this.tags.splice(i,1);
            }
        },
        watch:{
            tags(){
                this.$emit("change",this.tags);
            }
        }
    }
</script>

<style scoped>
    .error {
        color: red;
        font-size: 15px;
        display: block;
    }
</style>
