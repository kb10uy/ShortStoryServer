@foreach($bookmarks as $bookmark)
  <div class="cell">
    <div class="card">
      <div class="card-divider">
        <h3><a href="{{ route('bookmark.view', ['id' => $bookmark->id]) }}">{{ $bookmark->name }}</h3>
      </div>
      <div class="card-section">
        <p>
          {{ $bookmark->description }}
        </p>
      </div>
    </div>
  </div>
@endforeach