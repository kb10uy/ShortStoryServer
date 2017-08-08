window.$ = window.jQuery = require('jquery');
window._ = require('lodash');
window.Vue = require('vue');
window.axios = require('axios');
import Echo from "laravel-echo"

window.VueEvent = new Vue();

Vue.component('sss-post-tags', require('./components/Post.Tags.vue'));
Vue.component('popup-info', require('./components/Popup-Info.vue'));
Vue.component('nice-button', require('./components/NiceButton.vue'));
Vue.component('dopyulicate-button', require('./components/DopyulicateButton.vue'));
Vue.component('bookmark-dropdown', require('./components/BookmarkDropDown.vue'));
Vue.component('admin-user-tab', require('./components/admin/UserTab.vue'));
Vue.component('admin-post-tab', require('./components/admin/PostTab.vue'));
Vue.component('admin-server-tab', require('./components/admin/ServerTab.vue'));
window.VueInstance = new Vue({
    el: '#app'
});

window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': window.Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest'
};

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':443'
});
