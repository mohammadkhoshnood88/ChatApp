<template>
    <div>
    <input type="text"
    v-model="message"
    @keyup.enter="sendMessage()"
    placeholder=" type something ... " />

    <button class="btn btn-info"
    @click="sendMessage()"
    >
    send message
    </button>

    </div>
</template>

<script>

import Input from '../../Jetstream/Input.vue'

export default {
    components : {
        Input
    },
    props : [
        'room'
    ],
    data() {
        return {
            message : "",
        }
    },
    methods : {
        sendMessage() {
            if(this.message == ' '){
                return;
            }

            axios.post('/chat/room/' + this.room.id + "/message" , {
                message : this.message
            }).then( response => {

                if(response.status == 201){
                    this.message = "";                    
                    this.$emit('messagesent')
                }
            }).catch(error => {
                console.log(error)
            })
        }
    }
}
</script>