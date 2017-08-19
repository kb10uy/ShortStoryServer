window.$ = window.jQuery = require('jquery');
window._ = require('lodash');
window.Vue = require('vue');
window.axios = require('axios');
import Echo from "laravel-echo"

window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': window.Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest'
};

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':443'
});

Vue.component('sss-post-tags', require('./components/Post.Tags.vue'));
Vue.component('popup-info', require('./components/Popup-Info.vue'));
Vue.component('nice-button', require('./components/NiceButton.vue'));
Vue.component('dopyulicate-button', require('./components/DopyulicateButton.vue'));
Vue.component('bookmark-dropdown', require('./components/BookmarkSelection.vue'));
Vue.component('admin-user-tab', require('./components/admin/UserTab.vue'));
Vue.component('admin-post-tab', require('./components/admin/PostTab.vue'));
Vue.component('admin-server-tab', require('./components/admin/ServerTab.vue'));
Vue.component('oauth-authorized-clients', require('./components/auth/AuthorizedClients.vue'));
Vue.component('oauth-clients', require('./components/auth/Clients.vue'));
Vue.component('oauth-personal-tokens', require('./components/auth/PersonalAccessTokens.vue'));

window.VueEvent = new Vue();
window.VueInstance = new Vue({
    el: '#app'
});