<div class="small-12 columns">
  @foreach($post->tags as $tag)
    <span class="primary label"><a href="{{ route('post.search', ['q' => $tag->name, 'type'=> 'tag', 'sort' => 'updated']) }}" class="label-keep">{{ $tag->name }}</a></span>&nbsp;
  @endforeach
</div>