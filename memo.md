業務が忙しくなったため一旦Pending。いつか再開したいのでその時用のメモ。

# 実装中の機能

## 1.ブログ機能

### 使用技術

- AppSync
- easymde
- react-simplemde-editor
- marked
- isomorphic-dompurify


### 実装済み

- タイトル、本文のCRUD操作
- タグによる絞り込み

### 未了

#### 投稿・更新時の複数タグ追加（FE／BE）

VTLのOR検索でつまづき中(filterの使い方)

- 複数タグのinsert
- 複数IDによるタグ一覧の取得（contains文が上手くいかない）
- タグ一覧取得後、記事insert処理時にtagsのデータとして使いたい

#### 記事内で画像アップロード（FE／BE）

- **S3**へのアップロード処理を**Lambda**等にデプロイする予定（レスポンス後、URLを作ってmarkdownに出力）
- 記事投稿のタイミングではなく、ドラッグ＆ドロップ時にアップロードでよい

#### サムネイル設定（FE／BE） 

- 記事insert直前のタイミングでアップロード
- パスを`thumbnail_path`フィールドとして使う

---

## 2.認証機能

### 使用技術

#### Laravel側

- **auth0/login:"~6.0"**

#### Next.js

- **@auth0/auth0-react**


### 実装済み

#### React↔Auth0の認証

#### Laravel側での認証状態検証

**Bearer Token**を取得し、Auth0用のSDKを使って認証状態を検証する


### 未了

#### テストログイン

`ログイン`ボタンを押すと**Auth0** のログイン画面に遷移するように実装（その後コメントアウト）。あらかじめテスト用のアカウントをリクエストボディにセットしなければならない。

#### Authファサードへの影響未解決

**Laravel** 側では認証状態を検証したいだけなのに、Featureテストでログアウトがエラーになるなど、**Auth**ファサードに影響が出ている。
一旦 **auth0/login**をアンインストール中。

#### AppSyncでの認証チェック

テストログイン未了のため、認証は引き続き**Laravel**のデフォルトを利用中

- `Authorization`の処理を**Lambda**にデプロイする
- **AppSync**の認証設定に登録する

---

## その他の機能

[実装したい内容](https://keep.google.com/u/0/#LIST/1MZvJ2FisuflHYog8UvllZDS85ywMRPMnky29rlSSnBw8GM1BWUawOAbyeYd33KVAUiQ)

---

## 再開時の手順

### Python／Lambdaの勉強

### 記事追加・更新時に複数タグを設定できるようにする

- 関数1: tagsテーブルに未登録のタグを挿入

リクエスト時のタグデータ

```json:
{
  tags: [
    {
      id: "11111",
      name: "HTML"
    },
    {
      // これをまずtagsテーブルに新規追加
      name: "CSS"
    }
  ]
}
```

- 関数2: tagsテーブルをOR検索してタグ一覧を取得

取得後のタグデータ

```json:
{
  tags: [
    {
      id: "11111",
      name: "HTML"
    },
    {
      id: "22222",
      name: "CSS"
    }
  ]
}
```

- 関数3:blogsテーブルを挿入



- VTLが辛かったらLambdaに切り替える
- 処理成功後のtoast表示も忘れずに

### 記事内に画像の挿入ができるようにする

- PythonまたはNode.jsで処理を書き、Lambdaにデプロイ
- ドラッグ＆ドロップ時にリクエストを走らせる
- **AppSync**、**API Gateway**どっちか迷い中

### サムネイル設定

- Lambdaへのデプロイまでは画像挿入とほぼ同じ
- アップロードのタイミングは記事のinsert前
- ファイルパスを`thumbnail_path`フィールドとして記事の属性に付加


### 認証DBの移行

- **RDS** → **Auth0**に移行

### テストログイン

- Auth0に向かってテストログイン
- Laravel側でも処理の変更(auth0/loginの入れ直し等)


[面倒な認証を丸投げできる「Auth0」へ既存ユーザーをラクに移行する方法](https://www.webprofessional.jp/easily-migrate-existing-users-auth0/)


### AppSyncのAuthorization設定

- トークン検証の処理をLambdaにデプロイし、**AppSyncの設定画面**から認証モードとして選択する
- 認証が必要なmutationやqueryについては、スキーマ内で`@aws_lambda`というアノテーションを付ける

[AppSyncのLambda認証を試してみる](https://zenn.dev/merutin/articles/02960a57bb8947)