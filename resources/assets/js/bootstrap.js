window._ = require('lodash');

window.$ = window.jQuery = require('jquery');

window.Vue = require('vue');

require('foundation-sites');

window.axios = require('axios');

window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': window.Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest'
};

import Echo from "laravel-echo"

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '89b4cc51b9ed5145f608',
    encrypted: true
});
