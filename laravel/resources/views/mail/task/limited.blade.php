@component('mail::message')
{{ $notifiable->full_name }}さん<br />
{{ config('app.name') }}をご利用いただきありがとうございます。<br />
明日締切で「未着手」または「作業中」のタスクをお知らせいたします。<br /><br />

@component('mail::table')
@if($taskList->count())
| 締切時間 | 内容 | 優先度 | 進捗度 |
| :----------: |:----------------| :--------:| :--------: |
@foreach($taskList as $task)
| {{ $task['time_limit']->format('G:i') }} | {{ Str::limit($task['body']) }} | {{ $task['priority']->name }} | {{ $task['progress']->name }} |
@endforeach
@else
明日締切で「未着手」または「作業中」のタスクはありません
@endif
@endcomponent
@component('mail::button', ['url' => $detailUrl, 'color' => 'green'])
タスクをすべて見る
@endcomponent

このメールアドレスは送信専用となっております。本メールに対するご返信には対応致しかねますのでご了承下さい。
@endcomponent
