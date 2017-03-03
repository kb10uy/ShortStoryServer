<template>
  <div class="row small-12 columns">
    <h3>サーバーメッセージ送信</h3>
    <div class="input-group">
        <span class="input-group-label">Message</span>
        <input class="input-group-field" type="text" name="message" v-model="message" placeholder="送信したいメッセージ">
        <div class="input-group-button">
        <input type="button" id="admin-server-send-message" class="button" @click="sendServerMessage" value="送信">
        </div>
    </div>
  </div>
</template>

<script>
    export default {
        data: function() {
            return {
                message: '',
            };
        },
        methods: {
            sendServerMessage(event) {
                const mes = this.message;

                $('#admin-server-send-message').attr('disable', '');
                axios
                    .post('/api/admin/broadcast_server_message', {message: mes})
                    .then(function(r){
                        $('#admin-server-send-message').removeAttr('disable');
                    });
            },
        },
    }
</script>