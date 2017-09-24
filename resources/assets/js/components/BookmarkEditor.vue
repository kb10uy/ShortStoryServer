<template>
  <div class="grid-x grid-padding-x">
    <div class="small-12 cell">
      <label>
        ブックマークの名前
        <input type="text" placeholder="ブックマークの名前(必須)" :value="name">
      </label>
    </div>

    <div class="small-12 cell">
      <label>
        ブックマークの説明
        <textarea placeholder="ブックマークの説明" rows="3" :v-model="description"></textarea>
      </label>
    </div>

    <div class="small-12 cell">
      <table class="hover">
        <thead>
          <tr>
            <th>タイトル</th>
            <th>コメント</th>
            <th class="bme-table-move">操作</th>
            <th class="bme-table-tool">編集</th>
            <th class="bme-table-tool">削除</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="entry in entries" :key="entry.id">
            <td>{{ entry.post.title }}</td>
            <td>{{ entry.comment }}</td>
            <td class="bme-table-move">
              <button class="primary button">↑</button>
              <button class="primary button">↓</button>
            </td>
            <td class="bme-table-tool"><button class="primary button">編集</button></td>
            <td class="bme-table-tool"><button class="alert button">削除</button></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  props: ['bookmarkId'],

  data() {
    return {
      entries: [],
      name: '',
      description: '',
    };
  },

  mounted() {
    this.fetchBookmark();
  },

  methods: {
    fetchBookmark() {
      axios.get('/api/bookmarks/show', {
        params: {
          id: this.bookmarkId,
        },
      }).then((result) => {
        this.name = result.data.name;
        this.description = result.data.description;
      });
      axios.get('/api/bookmarks/entries', {
        params: {
          id: this.bookmarkId,
          include_posts: 1,
        },
      }).then((result) => {
        this.entries = result.data.data;
      });
    },

    moveUp(index) {

    },

    moveDown(index) {

    },
  },
}
</script>
