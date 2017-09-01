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
//thisはスコープが多分このコンポーネントになってしまうのでグロバのappはapp取らないと無理
//popup-messageイベントにターゲットの名前とメッセージ付けて発火すると出て来る
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
    var vm = this;
    VueEvent.$on('popup-message', function (target, msg) {
      if (target != vm.name) return;
      vm.message = msg;
      $('#' + vm.elementId).foundation('open');
    });
  },
}
</script>
