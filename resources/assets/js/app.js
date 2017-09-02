/* クライアントサイドの汎用処理
 * あとFoundationくんはapp.jsに居残り
 * だってそうしないと順序問題が
 */
import $ from 'jquery';

function getUrlParameter(name) {
  name = name.replace(/[[]/, '\\[').replace(/[\]]/, '\\]');
  var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
  var results = regex.exec(location.search);
  return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}

/**
 * 検索フィールドの挙動を設定します。
 * 多分後でVueコンポーネントに吸収される
 *
 * @export
 */
export function setSearchParameter() {
  const type = getUrlParameter('type'), sort = getUrlParameter('sort');
  if (type != '' && type != 'keyword') {
    $('#search-type').val(type);
    $('#search-sort').prop('disabled', false);
    $('#search-sort').val(sort);
  }
  $('#posts-list>div:last').addClass('end');
}


/**
 * foudationメソッドを実行します。
 *
 * @export
 * @param {string} target セレクタ文字列
 * @param {string} action アクション文字列
 */
export function performFoundation(target, action) {
  $(target).foundation(action);
}
