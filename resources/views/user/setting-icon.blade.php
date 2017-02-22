<div class="small-12 columns">
  <h3>@lang('view.user.icon')</h3>
</div>

<div class="small-6 medium-4 columns">
  <div class="callout" data-equalizer-watch>
    <img alt="Current icon" src="{{ Storage::url(Auth::user()->icon) }}">
  </div>
</div>

<div class="small-6 medium-8 columns" data-equalizer-watch>
  <ul>
    <li>@lang('view.user.icon_req_1')</li>
    <li>@lang('view.user.icon_req_2')</li>
    <li>@lang('view.user.icon_req_3')</li>
  </ul>
  <!-- アイコン アップロード -->
  <form role="form" method="POST" enctype="multipart/form-data" action="{{ route('user.update.icon') }}" data-abide novalidate>
    {{ csrf_field() }}
    <label for="fileupicon" class="button">@lang('view.user.icon_select')</label>
    <input type="file" name="file_icon" id="fileupicon" class="show-for-sr">
    <button class="button" type="submit" value="Submit">@lang('view.update')</button>
  </form>
</div>