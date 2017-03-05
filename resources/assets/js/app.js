/* クライアントサイドの汎用処理
 * あとFoundationくんはapp.jsに居残り
 * だってそうしないと順序問題が
 */
require('./bootstrap');
require('foundation-sites');

//Foundation
$(document).ready(function() {
  $(document).foundation();
});

// Emoji One変換対象にはwith-emojiクラス付加すること
$('.with-emoji').each(function(i, e) {
    e.innerHTML = emojione.toImage(e.innerHTML);
});