require('./bootstrap');

$(document).ready(() => {
  setSearchParameter();
});

$(window).on('beforeunload', (e) => {
  Echo.leave('server-information');
});

// Laravel Echoグローバル域 ------------------------------------------------------
Echo.channel('server-information')
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

function setSearchParameter() {
  const type = getUrlParameter('type'), sort = getUrlParameter('sort');
  if (type != '' && type != 'keyword') {
    $('#search-type').val(type);
    $('#search-sort').prop('disabled', false);
    $('#search-sort').val(sort);
  }
  $('#posts-list>div:last').addClass('end');
}

function getUrlParameter(name) {
  name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
  var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
  var results = regex.exec(location.search);
  return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
};
