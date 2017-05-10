@component('mail::message')
# ShortStoryServerからのお知らせです。

{{ $message }}


{{ config('app.name') }}
@endcomponent
