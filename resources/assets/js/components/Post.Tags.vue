<template>
  <div class="small-12 cell">
    <input type="hidden" name="tags" id="tags-field" v-bind:value="tagsValue">
    <div class="small-12 medium-4 cell">
      <div class="input-group">
        <input type="text" class="input-group-field" form="" v-model="newTagText" @keyup.enter="addTag">
        <div class="input-group-button">
          <button class="button" @click="addTag" type="button">追加</button>
        </div>
      </div>
    </div>
    <div class="small-12 medium-8 cell">
      <span v-for="(tag, i) in tags" :key="tag">
        <span class="label primary">
          {{ tag }}
          <a @click="tags.splice(i, 1)"><i class="label-keep fi-x"></i></a>
        </span>
        &nbsp;
      </span>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    //editから呼ばれた場合のタグのセット
    const oldtag = document.getElementById('post_hidden_tags');
    if (!oldtag) return;
    this.tags = JSON.parse(oldtag.value);
  },
  methods: {
    addTag(event) {
      const formed = this.newTagText.replace(/"/g, '');
      const list = formed.split(/\s+/, 32);
      list.forEach((nt) => {
        if (nt == '' || this.tags.indexOf(nt) >= 0) return;
        this.tags.push(nt);
      });

      this.newTagText = '';
    },
  },
  data() {
    return {
      newTagText: '',
      tags: [],
    };
  },
  computed: {
    tagsValue() {
      return this.tags
        .map((t) => t.replace(/'/g, '\\\''))
        .map((t) => '\'' + t + '\'')
        .join(', ');
    },
  },
}
</script>
