<template>
  <div class="reveal" v-bind:id="elementId" data-reveal data-close-on-click="true" data-animation-in="fade-in" data-animation-out="fade-out">
    <h1>Information</h1>
    <p class='lead'>{{ message }}</p>
    <button class="close-button" data-close aria-label="Close reveal" type="button">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
</template>

<script>
//popup-messageイベントにターゲットの名前とメッセージ付けて発火すると出て来る
import $ from 'jquery';
export default {
  props: ['name'],
  data() {
    return {
      message: '',
    };
  },
  computed: {
    elementId() {
      return 'popup-info-' + this.name;
    }
  },
  mounted() {
    VueEvent.$on('popup-message', (target, msg) => {
      if (target != this.name) return;
      this.message = msg;
      $('#' + this.elementId).foundation('open');
    });
  },
}
</script>
