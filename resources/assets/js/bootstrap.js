import Vue from 'vue';
import axios from 'axios';
import Echo from 'laravel-echo';

axios.defaults.headers.common = {
  'X-CSRF-TOKEN': window.Laravel.csrfToken,
  'X-Requested-With': 'XMLHttpRequest'
};

Vue.component('sss-post-tags', require('./components/Post.Tags.vue'));
Vue.component('popup-info', require('./components/Popup-Info.vue'));
Vue.component('nice-button', require('./components/NiceButton.vue'));
Vue.component('dopyulicate-button', require('./components/DopyulicateButton.vue'));
Vue.component('bookmark-dropdown', require('./components/BookmarkSelection.vue'));
Vue.component('bookmark-editor', require('./components/BookmarkEditor.vue'));
Vue.component('admin-user-tab', require('./components/admin/UserTab.vue'));
Vue.component('admin-post-tab', require('./components/admin/PostTab.vue'));
Vue.component('admin-server-tab', require('./components/admin/ServerTab.vue'));
Vue.component('oauth-authorized-clients', require('./components/auth/AuthorizedClients.vue'));
Vue.component('oauth-clients', require('./components/auth/Clients.vue'));
Vue.component('oauth-personal-tokens', require('./components/auth/PersonalAccessTokens.vue'));

window.VueEvent = new Vue();
window.VueInstance = new Vue({
  el: '#app',
});

window.EchoInstance = new Echo({
  broadcaster: 'socket.io',
  host: window.location.hostname + ':443',
});
