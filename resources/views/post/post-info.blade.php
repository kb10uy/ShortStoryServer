@php
    //仕方ない
    $_postinfo = $postinfo ?? $post->info();
@endphp

<div class="grid-x grid-padding-x">
  <div class="small-3 cell">
    <h5><i class="fi-eye"></i> {{ $_postinfo['view_count'] ?? 0 }}</h5>
  </div>
  <div class="small-3 cell">
    <h5><i class="fi-like"></i> {{ $_postinfo['nice_count'] ?? 0}}</h5>
  </div>
  <div class="small-3 cell">
    <h5><i class="fi-bookmark"></i> 0</h5>
  </div>
  <div class="small-3 cell">
    <h5><i class="fi-comment"></i> 0</h5>
  </div>
</div>
