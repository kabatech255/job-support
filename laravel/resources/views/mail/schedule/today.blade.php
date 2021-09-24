@component('mail::message')
{{ $notifiable->full_name }}さん<br />
{{ config('app.name') }}をご利用いただきありがとうございます。<br />
{{ $notifiable->full_name }}さんがカレンダーに登録された本日の予定をお知らせいたします。<br /><br />

@component('mail::table')
| 日時 | 内容 | 公開設定 |
| :---------- |:----------------| :--------: |
@forelse($scheduleList as $schedule)
| {{ $schedule['start']->format('n/j G:i') }} - {{ $schedule['end']->format('n/j G:i') }} | {{ $schedule['title'] }} | {{ $schedule['is_public'] ? '公開' : '非公開' }} |
@empty
| 本日の予定はありません |
@endforelse
@endcomponent
@component('mail::button', ['url' => $detailUrl, 'color' => 'green'])
カレンダーを見る
@endcomponent

このメールアドレスは送信専用となっております。本メールに対するご返信には対応致しかねますのでご了承下さい。
@endcomponent
