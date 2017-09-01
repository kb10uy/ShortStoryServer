<template>
  <button class="compressed button primary expanded" id="button-dopyulicate" @click="perform">
    {{ message }}
  </button>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      message: '',
    };
  },
  methods: {
    mounted() {
      this.message = this.tldopyu;
    },

    perform() {
      $('#button-dopyulicate').prop('disabled', true);
      axios.post('/api/posts/dopyulicate', {
        'id': this.id,
      })
      .then(() => {
        this.message = this.tldopyu_ok;
      });
    },
  },
  props: ['tldopyu', 'tldopyu_ok', 'id'],
}
</script>
