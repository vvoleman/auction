<template>
    <div class="w-100 position-fixed">
        <sidebar :loading="contacts.loading"
                 :error="contacts.error"
                 :contacts="contacts.data"
                 :opened="opened"
                 class="col-rl-2 col-md-3 "
                 @newMsg="sendMsg"
                 @open="changeChat"
        ></sidebar>
        <transition name="fade" mode="out-in">
            <chat
                    v-if="chatUsers.length > 0"
                    :users="chatUsers"
                    :msgs="currentChat.msgs"
                    :canNext="currentChat.next != false"
                    @newMsg="newChatMsg"
                    class="offset-rl-2 offset-md-3 col-rl-10 col-md-9"
                    style="padding-left:0;padding-right:0"
            ></chat>
        </transition>
    </div>
</template>

<script>
    /*
        offset-rl-2 offset-md-3
     */
    import Sidebar from "./sidebar";
    import Chat from "./chat";
    export default {
        name: "messenger",
        components: {Sidebar, Chat},
        props:["y_uuid"],
        data(){
            return {
                contacts:{
                    data:[],
                    loading:false,
                    error:false
                },
                you:null,
                chat:{
                    next:0,
                    msgs:[]
                },
                chat_history:{},
                opened:""
            }
        },
        mounted(){
            this.loadContacts();
            Echo.private(`user.messages.`+this.y_uuid)
                .listen('NewMessage',(e)=>{
                    console.log(e);
                    this.markAsSeen([e.message.msg.message_uuid]);
                    this.alterContacts({
                        conversation_uuid:e.message.conversation_uuid,
                        last_msg:e.message.msg
                    });
                    this.chat_history[this.opened].msgs.unshift(e.message.msg);
            });
        },
        methods:{
            loadContacts(){
                this.contacts.loading = true;
                axios.get("/ajax/messages/contacts")
                    .then((response)=>{
                        if(response.data.status != 200){
                            this.contacts.error = true;
                        }else{
                            this.contacts.error = false;
                            this.contacts.data = response.data.data;
                            if(this.contacts.data.length > 0){
                                this.changeChat(this.contacts.data[0].conversation_uuid);
                            }
                            this.you = response.data.you;
                        }
                    })
                    .catch((e)=>{
                        console.log(e);
                        this.contacts.error = true;
                    })
                    .then(()=>{
                        this.contacts.loading = false;
                    });
            },
            alterContacts(data){
                var match = this.contacts.data.findIndex((x)=>{
                    return x.conversation_uuid == data.conversation_uuid;
                });
                //if match != -1, replace last msg of that index, otherwise put new msg as first
                if(match != -1){
                    var temp = this.contacts.data[match];
                    temp.last_msg = data.last_msg;
                    this.contacts.data.splice(match,1);
                    this.contacts.data.unshift(temp);
                }else{
                    this.contacts.data.unshift(data);
                }
            },
            sendMsg(data){
                axios.post("/ajax/messages",data)
                    .then((response)=>{
                        if(response.data.status != 200){
                            //this.$snotify.error("Nebylo možné odeslat zprávuu!");
                        }else{
                            this.alterContacts(response.data.data);
                            this.chat_history[this.opened].msgs.unshift(response.data.data.last_msg);
                            this.changeChat(response.data.data.conversation_uuid);
                        }

                    })
                    .catch(e=>{
                        console.log(e);
                        this.$snotify.error("Nebylo možné odeslat zprávu!");
                    });
            },
            newChatMsg(str){
                this.sendMsg({to:this.currentContact.user.uuid,message:str});
            },
            loadMsgs(){
                axios.get("/ajax/messages/conversation",{
                    params:{
                        c_uuid:this.opened,
                        start:this.chat.next
                    }
                })
                    .then((response)=>{
                        if(response.data.status == 200){
                            this.chat.next = response.data.next;
                            this.chat.msgs = response.data.data.reverse();

                            this.$set(this.chat_history,this.opened,{
                                next:response.data.next,
                                msgs:response.data.data.reverse()
                            });
                            var unseen = this.getUnseen();
                            if(unseen.length > 0){
                                this.markAsSeen(unseen);
                            }
                        }
                    })
                    .catch((e)=>{

                    });
            },
            changeChat(uuid){
                this.opened = uuid;
                this.chat.next = 0;
                this.chat.msgs = [];
                if(this.chat_history[uuid] == null){
                    this.loadMsgs();
                }else{
                    this.chat = Object.assign({}, this.chat_history[uuid]);
                }


            },
            getUnseen(){
                var unseen = this.chat.msgs.filter((x)=>{
                    return x.seen_at == null && !x.you;
                });
                return unseen.map(x=>{
                    return x.message_uuid;
                });
            },
            markAsSeen(seen){
                axios.post("/ajax/messages/markAsSeen",{
                    uuids:seen
                })
                    .then(response=>{

                    })
                    .catch(e=>{
                        console.log(e);
                    });
            }
        },
        computed:{
            currentContact(){
                var match = this.contacts.data.filter((x)=>{
                    return x.conversation_uuid == this.opened;
                });
                if(match.length == 1 && this.opened.length > 0){
                    return match[0];
                }
                return null;
            },
            currentChat(){
                if(this.opened.length == 0 || this.chat_history[this.opened] == null) return {};
                return this.chat_history[this.opened]
            },
            chatUsers(){
                if(this.currentContact == null || this.you == null){
                    return [];
                }else{
                    var opposite = this.currentContact.user;
                    opposite.you = false;
                    var you = this.you;
                    you.you = true;

                    return [opposite,you];
                }

            }
        }
    }
</script>

<style scoped>

</style>
