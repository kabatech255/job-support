@component('mail::message')
{{ $notifiable->full_name }}さん<br /><br />

当サービスに招待されましたのでご連絡いたします。<br /><br />

@component('mail::button', ['url' => $accountSetupUrl, 'color' => 'green'])
参加する
@endcomponent

このメールアドレスは送信専用となっております。本メールに対するご返信には対応致しかねますのでご了承下さい。
@endcomponent
