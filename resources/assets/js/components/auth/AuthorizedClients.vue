<template>
<div class="grid-x">
  <div class="small-12 cell">
    <h4>認証済みのクライアント</h4>
  </div>

  <div class="small-12 cell">
    <table class="stack">
      <thead>
        <tr>
          <th>名前</th>
          <th>スコープ</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
       <tr v-for="token in tokens" :key="token.client.id">
         <th>{{ token.client.name }}</th>
         <th>{{ token.scopes.join(', ') }}</th>
         <th>
           <a href="#" @click="revokeClient(client)">許可を取り消す</a>
         </th>
       </tr>
      </tbody>
    </table>
  </div>
</div>
</template>

<script>
    export default {
        data() {
            return {
                tokens: []
            };
        },

        mounted() {
            this.getTokens();
        },

        methods: {
            getTokens() {
                axios
                    .get('/oauth/tokens')
                    .then(response => {
                        this.tokens = response.data;
                    });
            },

            revokeClient(token) {
                axios
                    .delete('/oauth/tokens/' + token.id)
                    .then(response => {
                        this.getTokens();
                    });
            }
        }
    }
</script>
