<template>
  <div class="row small-12 columns">
    <form role="form" action="#">
      <div class="input-group">
        <span class="input-group-label">Query</span>
        <input class="input-group-field" type="text" name="query" v-model="query" placeholder="投稿検索用クエリ(例 max:20)">
        <div class="input-group-button">
          <input type="button" class="button" id="admin-post-query" @click="startQuery" value="検索">
        </div>
      </div>
    </form>
    <h4>結果: {{ users.length }}件</h4>
    <table class="hover">
      <thead>
        <tr>
          <th class="text-center">Id</th>
          <th class="text-center">Title</th>
          <th class="text-center">Text</th>
          <th class="text-center">User</th>
        </tr>
      </thead>
      <transition-group name="user-list" tag="tbody">
        <tr v-for="user in users" v-bind:key="user.id">
          <th class="admin-table-id">{{ user.id }}</th>
          <th class="admin-table-title">{{ user.name }}</th>
          <th>{{ user.display_name }}</th>
          <th class="admin-table-title">{{ user.type }}</th>
        </tr>
      </transition-group>
    </table>
  </div>
</template>

<script>
import axios from 'axios';
import $ from 'jquery';
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
      $('#admin-post-query')
        .attr('disabled', '')
        .text('検索中…');
      axios
        .get('/api/posts/query', {
          params: {
            query: this.query,
            full: 1,
          }
        })
        .then(function(r) {
          vm.users = r.data;
          $('#admin-post-query')
            .removeAttr('disabled')
            .text('検索');
        });
    },
  },
}
</script>
