<template>
    <div class="white_box">
        <div class="chat_window">
            <li v-for="(o,i) in messages" :key="o.message_uuid"><b :class="{'you':isItYou(o.author)}">{{(isItYou(o.author) ? "Vy" : "Protějšek")}}:</b> <span>{{o.message}}</span>
            </li>
        </div>
        <div class="chat_input d-flex">
            <textarea class="form-control col-10" v-model="text">

            </textarea>
            <button class="col-2" @click="sendMsg">Odeslat</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Chat",
        props: ['you_uuid', 'opposite_uuid', "os_id", "new_message"],
        data() {
            return {
                messages: [],
                text:""
            }
        },
        mounted() {
            this.getMessages();
        },
        methods: {
            sendMsg() {
                if(this.text.length == 0){
                    return;
                }
                axios.post("/ajax/messages", {
                    to: this.opposite_uuid,
                    message: this.text,
                    offersell_id: this.os_id
                });
                this.text = "";
            },
            getMessages() {
                axios.get("/ajax/messages/offersells", {
                    params: {
                        with_uuid: this.opposite_uuid,
                        os_id: this.os_id
                    }
                })
                    .then(response=>{
                        this.messages = response.data;
                    });
            },
            isItYou(uuid){
                return this.you_uuid == uuid;
            }
        },
        watch:{
            new_message(){
                this.messages.push(this.new_message);
            }
        }
    }
</script>

<style scoped>
    .chat_window {
        height: 200px;
        border: 1px solid #ccc;
        background: #efefef;
        overflow: auto;
    }

    li {
        list-style-type: none;
    }

    .you {
        color: purple;
    }
</style>
