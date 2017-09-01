<template>
  <div class="input-group">
    <select class="input-group-field" name="target" id="sel-bookmark" v-model="selected">
      <option v-for="bookmark in bookmarks" :value="bookmark.id" :key="bookmark.id">{{ bookmark.name }}</option>
    </select>
    <div class="input-group-button">
      <button class="button" :disabled="!performable" @click="addToBookmark">{{ message }}</button>
    </div>
  </div>
</template>

<script>
export default {
  props: ['tl_add', 'tl_already', 'id', 'user_id'],
  data() {
    return {
      bookmarks: [],
      message: '',
      performable: false,
      selected: 0,
    };
  },
  methods: {
    fetchBookmarks() {
      axios
        .get('/api/users/bookmarks', {
          params: {
            user_id: this.user_id
          }
        })
        .then(response => {
          this.bookmarks = response.data;
          if (this.bookmarks.length == 0) return;
          this.performable = true;
          this.selected = this.bookmarks[0].id;
        });
    },
    addToBookmark() {
      this.performable = false;
      axios
        .patch('/api/bookmarks/add', {
          post_id: this.id,
          bookmark_id: this.selected,
        })
        .then(response => {
          this.performable = true;
        })
        .catch(error => {
          if (error.response.status == 409) {
            this.message = this.tl_already;
            setTimeout(() => {
              this.performable = true;
              this.message = this.tl_add;
            }, 1000);
          }
        });
    },
  },
  mounted() {
    this.fetchBookmarks();
    this.message = this.tl_add;
  }
}
</script>
