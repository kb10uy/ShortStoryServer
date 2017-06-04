<script type="text/javascript" src="{{ mix('/js/app.js') }}"></script>
@if($admin ?? false)
  <script type="text/javascript" src="{{ mix('/js/admin.js') }}"></script>
@else
  <script type="text/javascript" src="{{ mix('/js/user.js') }}"></script>
@endif
<script type="text/javascript">
  $(document).foundation();
</script>