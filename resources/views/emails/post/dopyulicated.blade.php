@component('mail::message')
# あなたの作品がシコられました！

あなたが投稿した **{{ $post->title }}** がシコられました。
おめでとうございます。

@component('mail::button', ['url' => route('post.view', [$post->id]), 'color' => 'blue'])
自分でシコりに行く
@endcomponent

今後もさらなる活躍をお祈りします。
{{ config('app.name') }}
@endcomponent
