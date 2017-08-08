<div class="grid-x grid-padding-x small-up-1 medium-up-1 large-up-2" id="posts-list">
  @foreach($posts as $post)
    <div class="cell">
      <div class="card">
        <div class="card-divider">
          <h3><a href="{{ route('post.view', ['id' => $post->id]) }}">{{ $post->title }}</a>&nbsp;<small>by {{ $post->user->display_name }}</small></h3>
        </div>
        <div class="card-section">
          @include('post.post-info')
          @include('post.post-tags')
        </div>
        <div class="card-section">
          <p>
            {{ $post->digest() }}
          </p>
        </div>
      </div>
    </div>
  @endforeach
</div>
{{ $posts->links() }}