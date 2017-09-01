<template>
  <button class="compressed button primary expanded" id="button-dopyulicate" @click="perform">
    {{ tldopyu }}
  </button>
</template>

<script>
export default {
  methods: {
    perform() {
      let vm = this;
      $('#button-dopyulicate').prop('disabled', true);
      axios.post('/api/posts/dopyulicate', {
        'id': vm.id,
      })
        .then(function() {
          $('#button-dopyulicate').html(vm.tldopyu_ok);
        });
    },
  },
  props: ['tldopyu', 'tldopyu_ok', 'id'],
}
</script>
