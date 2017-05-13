<script src="//{{ Request::getHost() }}:{{ env('SOCKETIO_PORT') }}/socket.io/socket.io.js"></script>
<script type="text/javascript" src="{{ mix('/js/manifest.js') }}"></script>
<script type="text/javascript" src="{{ mix('/js/vendor.js') }}"></script>
<script src="https://cdn.jsdelivr.net/emojione/2.2.7/lib/js/emojione.min.js"></script>
<script type="text/javascript" src="{{ mix('/js/app.js') }}"></script>
@if($admin ?? false)
  <script type="text/javascript" src="{{ mix('/js/admin.js') }}"></script>
@else
  <script type="text/javascript" src="{{ mix('/js/user.js') }}"></script>
@endif