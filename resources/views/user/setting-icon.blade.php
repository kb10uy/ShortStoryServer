<div class="small-12 columns">
  <h3>アイコン</h3>
</div>

<div class="small-6 medium-4 columns">
  <div class="callout" data-equalizer-watch>
    <img alt="Current icon" src="{{ Storage::url(Auth::user()->icon) }}">
  </div>
</div>

<div class="small-6 medium-8 columns" data-equalizer-watch>
  <ul>
    <li>対応形式: PNG, JPEG, GIF</li>
    <li>最大サイズ: 1024x1024, 512KB</li>
    <li>内部で320x320 JPEGに縮小・変換されます</li>
  </ul>
  <!-- アイコン アップロード -->
  <form role="form" method="POST" enctype="multipart/form-data" action="{{ route('user.update.icon') }}" data-abide novalidate>
    {{ csrf_field() }}
    <label for="fileupicon" class="button">ファイルを選択</label>
    <input type="file" name="file_icon" id="fileupicon" class="show-for-sr">
    <button class="button" type="submit" value="Submit">更新</button>
  </form>
</div>