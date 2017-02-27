<template>
  <div class="small-12 columns">
    <input type="hidden" name="tags" id="tags-field" v-bind:value="tagsValue">
    <div class="small-12 medium-4 columns">
      <div class="input-group">
        <input type="text" class="input-group-field" form="" v-model="newTagText" @keyup.enter="addTag">
        <div class="input-group-button">
          <a class="button" @click="addTag">追加</a>
        </div>
      </div>
    </div>
    <div class="small-12 medium-8 columns">
      <span v-for="(tag, i) in tags">
        <span class="label primary">
          {{ tag }} <a @click="tags.splice(i, 1)"><i class="label-keep fi-x"></i></a>
        </span>
        &nbsp;
      </span>
    </div>
  </div>
</template>

<script>
    export default {
        mounted() {
            
        }, 
        methods: {
            addTag(event) {
                if (this.newTagText.replace(/"/g, '') == '') return;
                this.tags.push(this.newTagText.replace(/"/g, ''));
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
                    .map((t) => t.replace(/'/g, "\\\'"))
                    .map((t) => "\'" + t + "\'")
                    .join(", ");
            },
        },
    }
</script>
