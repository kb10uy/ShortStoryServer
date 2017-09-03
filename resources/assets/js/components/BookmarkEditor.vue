<template>
  <div class="grid-x grid-padding-x">
    <div class="small-12 cell">
      <label>
        ブックマークの名前
        <input type="text" placeholder="ブックマークの名前(必須)">
      </label>
    </div>

    <div class="small-12 cell">
      <label>
        ブックマークの説明
        <textarea placeholder="ブックマークの説明" rows="3"></textarea>
      </label>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  props: ['bookmarkId'],
  data() {
    return {
      posts: [],
    };
  },
  methods: {
    mounted() {
      this.fetchBookmark();
    },

    fetchBookmark() {
      axios.get('/api/bookmarks/show', {
        params: {
          user_id: this.user_id
        }
      }).then(result => {
        this.posts = result.data;
      });
    },

    moveUp(index) {

    },

    moveDown(index) {

    },
  }
}
</script>
