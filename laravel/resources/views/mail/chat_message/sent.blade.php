@component('mail::message')
{{ $notifiable->full_name }}さん<br />
{{ config('app.name') }}をご利用いただきありがとうございます。<br />
{{ $chatMessage['sent_user'] }}さんから新着メッセージが届きました。<br />

# メッセージ概要

@component('mail::panel')
<dt>[ルーム名]</dt>
<dd>{{ $chatMessage['chat_room_name'] }}</dd>
<dt>[送信日時]</dt>
<dd>{{ $chatMessage['created_at']->format('n月j日 G:i') }}</dd>
<dt>[メッセージ]</dt>
<dd>{{ $chatMessage['message_body'] }}</dd>
@endcomponent

@component('mail::button', ['url' => $detailUrl, 'color' => 'green'])
詳細の確認
@endcomponent

このメールアドレスは送信専用となっております。本メールに対するご返信には対応致しかねますのでご了承下さい。
@endcomponent
