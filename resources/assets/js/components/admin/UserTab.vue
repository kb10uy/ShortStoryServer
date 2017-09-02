<template>
  <div class="row small-12 columns">
    <form role="form" action="#">
      <div class="input-group">
        <span class="input-group-label">Query</span>
        <input class="input-group-field" type="text" name="query" v-model="query" placeholder="ユーザー検索用クエリ(例 max:20)">
        <div class="input-group-button">
          <input type="button" class="button" id="admin-user-query" @click="startQuery" value="検索">
        </div>
      </div>
    </form>
    <h4>結果: {{ users.length }}件</h4>
    <table class="hover">
      <thead>
        <tr>
          <th class="text-center">Id</th>
          <th class="text-center">Name</th>
          <th class="text-center">Display Name</th>
          <th class="text-center">Type</th>
        </tr>
      </thead>
      <transition-group name="user-list" tag="tbody">
        <tr v-for="user in users" v-bind:key="user.id">
          <th class="admin-table-id">{{ user.id }}</th>
          <th class="admin-table-title">{{ user.name }}</th>
          <th>{{ user.display_name }}</th>
          <th class="admin-table-type">{{ user.type }}</th>
        </tr>
      </transition-group>
    </table>
  </div>
</template>

<script>
import $ from 'jquery';
import axios from 'axios';
export default {
  data: function() {
    return {
      query: '',
      users: [],
    };
  },
  methods: {
    startQuery() {
      var vm = this;
      $('#admin-user-query')
        .attr('disabled', '')
        .text('検索中…');
      axios
        .get('/api/users/query', {
          params: {
            query: this.query,
            full: 1,
          }
        })
        .then(function(r) {
          vm.users = r.data;
          $('#admin-user-query')
            .removeAttr('disabled')
            .text('検索');
        });
    },
  },
}
</script>
