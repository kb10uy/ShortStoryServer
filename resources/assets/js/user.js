require('./bootstrap');

//Laravel Echoグローバル域
Echo.channel('server-information')
    .listen('ServerInformed', (e) => {
        VueEvent.$emit('popup-message', 'server', e.message);
    });