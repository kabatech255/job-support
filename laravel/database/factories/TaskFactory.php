<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Task;
use Faker\Factory;
use App\Models\Priority;
use App\Models\Progress;

$taskList = [
  '資料作成',
  '資料作成',
  '資料作成',
  '資料作成',
  '資料作成',
  'ミーティング資料作成',
  'ミーティング資料作成',
  'ミーティング資料作成',
  'ミーティング資料作成',
  'ミーティング資料作成',
  '研修資料の作成',
  '研修資料の作成',
  '新入社員用AWSアカウント作成',
  '新入社員用AWSアカウント作成',
  'プレゼン資料作成',
  '集計',
  'トップページのUI実装',
  'Terraformでインフラをコード化する',
  '新サービスのプロトタイプをAmplifyにデプロイする',
  'Redmineをherokuにデプロイする',
  'ステージング環境を構築する',
  '認証データを状態管理ツールでグローバル化する',
  '新しい本番環境のアーキテクチャ設計',
  '追加機能の要件定義',
];

$faker = Factory::create('ja_JP');
$factory->define(Task::class, function ($faker) use ($taskList) {
  return [
    'meeting_decision_id' => null,
    'owner_id' => $faker->randomNumber,
    'created_by' => $faker->randomNumber,
    'priority_id' => array_random(Priority::all()->pluck('id')->toArray()),
    'progress_id' => array_random(Progress::all()->pluck('id')->toArray()),
    'body' => array_random($taskList),
    'time_limit' => $faker->dateTimeThisMonth,
  ];
});
