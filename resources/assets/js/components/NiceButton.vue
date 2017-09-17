<template>
  <div class="compressed button-group expanded">
    <button class="button hollow">{{ nice }}</button>
    <button class="button" id="button-nice" @click="perform" :disabled="!performable">{{ tlnice }}</button>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  props: ['tlnice', 'tlnice_ok', 'id', 'nice_count'],
  data() {
    return {
      nice: 0,
      performable: true,
    };
  },
  methods: {
    perform() {
      let vm = this;
      this.performable = false;
      axios.patch('/api/posts/nice', {
        'id': vm.id,
      }).then(() => {
        this.performable = true;
        vm.nice++;
      });
    },
  },
  mounted() {
    this.nice = this.nice_count;
  },
}
</script>
