<div class="row"  data-equalizer data-equalize-on="medium" id="posts-list">
  @foreach($posts as $post)
    <div class="small-12 large-6 columns">
      <div class="callout" data-equalizer-watch>
        <h3><a href="{{ route('post.view', ['id' => $post->id]) }}">{{ $post->title }}</a>&nbsp;<small>by {{ $post->user->display_name }}</small></h3>
        @include('post.post-info')
        <p>
          {{ $post->digest() }}
        </p>
      </div>
    </div>
  @endforeach
</div>
{{ $posts->links() }}