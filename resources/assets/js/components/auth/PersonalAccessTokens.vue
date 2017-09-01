<template>
  <div class="grid-x">
    <div class="small-12 large-8 cell">
      <h4>アクセストークン</h4>
    </div>
    <div class="small-12 large-4 cell">
      <button type="button" class="expanded button" data-open="modal-new-token">新規作成</button>
    </div>

    <div class="small-12 cell">
      <table class="stack">
        <thead>
          <tr>
            <th>名前</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="token in tokens" :key="token.name">
            <th>{{ token.name }}</th>
            <th>
              <a href="#" @click="destroyToken(token)">削除</a>
            </th>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="reveal" id="modal-new-token" data-reveal>
      <h3>新しいトークンを作成</h3>
      <div class="alert callout" v-if="form.errors.length > 0">
        <h4>エラー！</h4>
        <ul>
          <li v-for="error in form.errors" :key="error">{{ error }}</li>
        </ul>
      </div>
      <form @submit.prevent="createToken">
        <div class="grid-x grid-padding-x">
          <div class="small-3 large-4 cell">
            <label for="new-token-name" class="text-right middle">名前</label>
          </div>
          <div class="small-9 large-8 cell">
            <input type="text" id="new-token-name" placeholder="新しいクライアントの名前" v-model="form.name">
          </div>

          <div class="small-3 large-4 cell">
            <label for="new-token-scope" class="text-right middle">スコープ</label>
          </div>
          <div class="small-9 large-8 cell">
            <fieldset id="new-token-scope">
              <div v-for="scope in scopes" :key="scope.id">
                <input :id="'scope' + scope.id" type="checkbox" @click="toggleScope(scope.id)" :checked="scopeIsAssigned(scope.id)">
                <label :for="'scope' + scope.id">{{ scope.id }}</label>
              </div>
            </fieldset>
          </div>

          <div class="small-12 cell">
            <button class="expanded button" type="button" @click="createToken">作成</button>
          </div>
        </div>
      </form>

      <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>

    <div class="reveal" id="modal-show-token" data-reveal>
      <h3>トークンが作成されました！</h3>
      <p>
        このトークンはこのウィンドウを閉じると二度と表示されません！注意してください。
      </p>
      <div>{{ accessToken }}</div>

      <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  </div>
</template>

<script>
export default {
  /*
   * The component's data.
   */
  data() {
    return {
      accessToken: null,

      tokens: [],
      scopes: [],

      form: {
        name: '',
        scopes: [],
        errors: []
      }
    };
  },

  mounted() {
    this.getTokens();
    this.getScopes();
  },

  methods: {

    getTokens() {
      axios
        .get('/oauth/personal-access-tokens')
        .then(response => {
          this.tokens = response.data;
        });
    },

    getScopes() {
      axios
        .get('/oauth/scopes')
        .then(response => {
          this.scopes = response.data;
        });
    },

    createToken() {
      this.accessToken = null;

      this.form.errors = [];

      axios
        .post('/oauth/personal-access-tokens', this.form)
        .then(response => {
          this.form.name = '';
          this.form.scopes = [];
          this.form.errors = [];

          this.tokens.push(response.data.token);

          this.showAccessToken(response.data.accessToken);
        })
        .catch(error => {
          if (typeof error.response.data === 'object') {
            this.form.errors = _.flatten(_.toArray(error.response.data));
          } else {
            this.form.errors = ['Something went wrong. Please try again.'];
          }
        });
    },

    toggleScope(scope) {
      if (this.scopeIsAssigned(scope)) {
        this.form.scopes = _.reject(this.form.scopes, s => s == scope);
      } else {
        this.form.scopes.push(scope);
      }
    },

    scopeIsAssigned(scope) {
      return _.indexOf(this.form.scopes, scope) >= 0;
    },

    /**
     * Show the given access token to the user.
     */
    showAccessToken(accessToken) {
      $('#modal-new-token').foundation('close');

      this.accessToken = accessToken;

      $('#modal-show-token').foundation('open');
    },

    destroyToken(token) {
      axios
        .delete('/oauth/personal-access-tokens/' + token.id)
        .then(response => {
          this.getTokens();
        });
    }
  }
}
</script>
