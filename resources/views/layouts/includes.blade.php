<!-- Node.js Compiled Resources -->
<script>
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>

<link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
<link rel="stylesheet" type="text/css" href="{{ mix('/css/app.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/foundation-icons/3.0/foundation-icons.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/emojione/2.2.7/assets/css/emojione.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.1/socket.io.slim.js"></script>
<script type="text/javascript" src="{{ mix('/js/manifest.js') }}"></script>
<script type="text/javascript" src="{{ mix('/js/vendor.js') }}"></script>
<script src="https://cdn.jsdelivr.net/emojione/2.2.7/lib/js/emojione.min.js"></script>