<!-- Node.js Compiled Resources -->
<script>
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>

<link rel="stylesheet" type="text/css" href="{{ mix('/css/app.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/foundation-icons/3.0/foundation-icons.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/emojione/2.2.7/assets/css/emojione.min.css"/>