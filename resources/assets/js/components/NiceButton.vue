<template>
    <button class="button primary" id="button-nice" @click="perform">{{ tlnice }}</button>
</template>

<script>
    export default {
        methods: {
            perform() {
                let vm = this;
                $('#button-nice').prop('disabled', true);
                axios.patch('/api/posts/nice', {
                    'id': vm.id,
                })
                .then(function() {
                    $('#button-nice')
                        .prop('disabled', false)
                        .html(vm.tlnice_ok)
                        .delay(1000)
                        .html(vm.tlnice);
                });
            },
        },
        props: ['tlnice', 'tlnice_ok', 'id'],
    }
</script>