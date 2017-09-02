<template>
  <div class="grid-x">
    <div class="small-12 large-8 cell">
      <h4>OAuth クライアント</h4>
    </div>
    <div class="small-12 large-4 cell">
      <button type="button" class="expanded button" data-open="modal-new-client">新規作成</button>
    </div>

    <div class="small-12 cell">
      <table class="stack">
        <thead>
          <tr>
            <th>ID</th>
            <th>名前</th>
            <th>Secret</th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="client in clients" :key="client.id">
            <th>{{ client.id }}</th>
            <th>{{ client.name }}</th>
            <th>{{ client.secret }}</th>
            <th>
              <a href="#" @click="editClient(client)">編集</a>
            </th>
            <th>
              <a href="#" @click="destroyClient(client)">削除</a>
            </th>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="reveal" id="modal-new-client" data-reveal>
      <h3>新しいクライアントを作成</h3>
      <div class="alert callout" v-if="createForm.errors.length > 0">
        <h4>エラー！</h4>
        <ul>
          <li v-for="error in createForm.errors" :key="error">{{ error }}</li>
        </ul>
      </div>
      <form>
        <div class="grid-x grid-padding-x">
          <div class="small-3 large-4 cell">
            <label for="new-client-name" class="text-right middle">名前</label>
          </div>
          <div class="small-9 large-8 cell">
            <input type="text" id="new-client-name" placeholder="新しいクライアントの名前" v-model="createForm.name">
          </div>

          <div class="small-3 large-4 cell">
            <label for="new-client-url" class="text-right middle">コールバック URL</label>
          </div>
          <div class="small-9 large-8 cell">
            <input type="text" id="new-client-url" placeholder="認証後にジャンプするURL" v-model="createForm.redirect">
          </div>

          <div class="small-12 cell">
            <button class="expanded button" type="button" @click="createClient">作成</button>
          </div>
        </div>
      </form>

      <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>

    <div class="reveal" id="modal-edit-client" data-reveal>
      <h3>クライアントを編集</h3>
      <div class="alert callout" v-if="editForm.errors.length > 0">
        <h4>エラー！</h4>
        <ul>
          <li v-for="error in editForm.errors" :key="error">{{ error }}</li>
        </ul>
      </div>
      <form>
        <div class="grid-x grid-padding-x">
          <div class="small-3 large-4 cell">
            <label for="new-client-name" class="text-right middle">名前</label>
          </div>
          <div class="small-9 large-8 cell">
            <input type="text" id="new-client-name" placeholder="名前" v-model="editForm.name">
          </div>

          <div class="small-3 large-4 cell">
            <label for="new-client-url" class="text-right middle">コールバック URL</label>
          </div>
          <div class="small-9 large-8 cell">
            <input type="text" id="new-client-url" placeholder="認証後にジャンプするURL" v-model="editForm.redirect">
          </div>

          <div class="small-12 cell">
            <button class="expanded button" type="button" @click="updateClient">更新</button>
          </div>
        </div>
      </form>

      <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import $ from 'jquery';
import _ from 'lodash';
export default {
  /*
   * The component's data.
   */
  data() {
    return {
      clients: [],

      createForm: {
        errors: [],
        name: '',
        redirect: ''
      },

      editForm: {
        errors: [],
        name: '',
        redirect: ''
      }
    };
  },

  mounted() {
    this.getClients();
  },

  methods: {
    getClients() {
      axios
        .get('/oauth/clients')
        .then(response => {
          this.clients = response.data;
        });
    },

    createClient() {
      this.persistClient(
        'post', '/oauth/clients',
        this.createForm, '#modal-new-client'
      );
    },

    editClient(client) {
      this.editForm.id = client.id;
      this.editForm.name = client.name;
      this.editForm.redirect = client.redirect;

      $('#modal-edit-client').foundation('open');
    },

    updateClient() {
      this.persistClient(
        'put', '/oauth/clients/' + this.editForm.id,
        this.editForm, '#modal-edit-client'
      );
    },

    persistClient(method, uri, form, modal) {
      form.errors = [];

      axios[method](uri, form)
        .then(response => {
          this.getClients();

          form.name = '';
          form.redirect = '';
          form.errors = [];

          $(modal).foundation('close');
        })
        .catch(error => {
          if (typeof error.response.data === 'object') {
            form.errors = _.flatten(_.toArray(error.response.data));
          } else {
            form.errors = ['Something went wrong. Please try again.'];
          }
        });
    },

    destroyClient(client) {
      axios
        .delete('/oauth/clients/' + client.id)
        .then(response => {
          this.getClients();
        });
    }
  }
}
</script>
