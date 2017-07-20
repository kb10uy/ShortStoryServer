<div class="grid-x">
  @if(Session::has('success'))
  <div class="success callout small-12 cell" data-closable>
    <h4>Success</h4>
    {{ Session::get('success') }}

    <button class="close-button" aria-label="Dismiss" type="button" data-close>
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif

  @if(Session::has('warning'))
  <div class="warning callout small-12 cell" data-closable>
    <h4>Success</h4>
    {{ Session::get('warning') }}

    <button class="close-button" aria-label="Dismiss" type="button" data-close>
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif

  @if($errors->any() || Session::has('alert'))
  <div data-abide-error class="alert callout small-12 cell" data-closable>
    <h4>Error</h4>
    <ul>
      @foreach($errors->all() as $message)
        <li>{{ $message }}</li>
      @endforeach
    </ul>
    @if(Session::has('alert'))
      {{ Session::get('alert') }}
    @endif

    <button class="close-button" aria-label="Dismiss" type="button" data-close>
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
</div>