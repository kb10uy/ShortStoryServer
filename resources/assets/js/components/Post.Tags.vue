<template>
  <span>
    <span v-for="tag in tags">{{ tag }} (削除)</span>
  </span>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }, 
        data() {
            return {
                tags: ['うんこ']
            };
        }
    }
</script>
