<template>
  <div class="compressed button-group expanded">
    <button class="button hollow">{{ nice }}</button>
    <button class="button" id="button-nice" @click="perform">{{ tlnice }}</button>
  </div>
</template>

<script>
    export default {
        props: ['tlnice', 'tlnice_ok', 'id', 'nice_count'],
        data() {
            return {
                nice: 0,
            }
        },
        methods: {
            perform() {
                let vm = this;
                $('#button-nice').prop('disabled', true);
                axios.patch('/api/posts/nice', {
                    'id': vm.id,
                })
                .then(function() {
                    $('#button-nice')
                        .prop('disabled', false);
                    vm.nice++;
                });
            },
        },
        mounted() {
            this.nice = this.nice_count;
        },
    }
</script>