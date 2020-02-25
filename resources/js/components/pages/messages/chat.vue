<template>
	<div class="bg-red">
        <div class="">
            <div></div>
        </div>
    </div>
</template>
<script>
	export default{
		name:"chat",
		data(){
			return {
				messages:[],
                users:[
                    {
                        name:"Marco"
                    }
                ]
			}
		}
	}
</script>
<style scoped>

    .type_msg {border-top: 1px solid #c4c4c4;position: relative;}
    .msg_send_btn {
        background: #05728f none repeat scroll 0 0;
        border: medium none;
        border-radius: 50%;
        color: #fff;
        cursor: pointer;
        font-size: 17px;
        height: 33px;
        position: absolute;
        right: 0;
        top: 11px;
        width: 33px;
    }
    .messaging { padding: 0 0 50px 0;}
    .msg_history {
        height: 516px;
        overflow-y: auto;
    }.inbox_msg {
         border: 1px solid #c4c4c4;
         clear: both;
         overflow: hidden;
     }
    .top_spac{ margin: 20px 0 0;}
    .active_chat{ background:#ebebeb;}

    .incoming_msg_img {
        display: inline-block;
        width: 6%;
    }
    .received_msg {
        display: inline-block;
        padding: 0 0 0 10px;
        vertical-align: top;
        width: 92%;
    }
    .time_date {
        color: #747474;
        display: block;
        font-size: 12px;
        margin: 8px 0 0;
    }
    .received_withd_msg { width: 57%;}
    .mesgs {
        float: left;
        padding: 30px 15px 0 25px;
        width: 60%;
    }
    .outgoing_msg{ overflow:hidden; margin:26px 0 26px;}
    .sent_msg {
        float: right;
        width: 46%;
    }

</style>
