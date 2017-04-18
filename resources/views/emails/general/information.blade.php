@component('mail::message')
# ShortStoryServerからのお知らせです。

{{ $message }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
