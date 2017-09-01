import $ from 'jquery';
import { setSearchParameter } from './app';

$(document).ready(() => {
  setSearchParameter();
});

$(window).on('beforeunload', (e) => {
  EchoInstance.leave('server-information');
});

// Laravel Echoグローバル域 ------------------------------------------------------
EchoInstance.channel('server-information')
  .listen('ServerInformed', (e) => {
    VueEvent.$emit('popup-message', 'server', e.message);
  });

// 検索欄用ビヘイビア ------------------------------------------------------------
$('#search-type').change(function () {
  if ($('#search-type').val() == 'keyword') {
    $('#search-sort').prop('disabled', true);
    $('#search-sort').val('');
  } else {
    $('#search-sort').prop('disabled', false);
    $('#search-sort').val('updated');
  }
});

// Emoji One変換(対象にはwith-emojiクラス付加すること) ---------------------------
$('.with-emoji').each(function (i, e) {
  e.innerHTML = emojione.toImage(e.innerHTML);
});

$(document).foundation();
