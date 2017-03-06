require('./bootstrap');

//Laravel Echoグローバル域
Echo.channel('server-information')
    .listen('ServerInformed', (e) => {
        VueEvent.$emit('popup-message', 'server', e.message);
    });

//検索欄用ビヘイビア
$('#search-type').change(function() {
    if ($('#search-type').val() == 'keyword') {
        $('#search-sort').prop('disabled', true);
        $('#search-sort').val('');
    } else {
        $('#search-sort').prop('disabled', false);
        $('#search-sort').val('updated');
    }
});