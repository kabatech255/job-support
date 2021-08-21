<p>
  {{ config('app.name') }}をご利用いただきありがとうございます。<br>パスワード再設定のご依頼がありましたので、下記の通りご案内いたします。
</p>

<p>
  <span>再設定のURLはこちら</span>
  <a href="{{ $resetUrl }}" target="_blank" rel="noopener noreferrer">{{ $resetUrl }}</a>
</p>

<p>
  上記リンクURLの有効期限は<strong>{{ config('auth.passwords.users.expire') }}分</strong>です。<br />
  {{ config('auth.passwords.users.expire') }}分を過ぎましたら、お手数ですが以下より再度お手続きをお願いします。<br>
  <a href="{{ $forgotPasswordUrl }}" target="_blank" rel="noopener noreferrer">{{ $forgotPasswordUrl }}</a>
</p>

<p>このメールアドレスは送信専用となっております。本メールに対するご返信には対応致しかねますのでご了承下さい。</p>
