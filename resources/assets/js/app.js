/* クライアントサイドの汎用処理
 * あとFoundationくんはapp.jsに居残り
 * だってそうしないと順序問題が
 */
require('./bootstrap');

Vue.component('sss-post-tags', require('./components/Post.Tags.vue'));

//Foundation
$(document).ready(function() {
  $(document).foundation();
});

// Emoji One変換対象にはwith-emojiクラス付加すること
$('.with-emoji').each(function(i, e) {
    e.innerHTML = emojione.toImage(e.innerHTML);
});

const app = new Vue({
    el: '#app',
    data: {
        information: {
            message: ''
        }
    }
});

//Laravel Echoグローバル域
Echo.channel('server-information')
    .listen('ServerInformed', (e) => {
        app.information.message = e.message;
        $('#modal-information').foundation('open');
    });
