<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActionTypesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('action_types', function (Blueprint $table) {
      $table->id();
      $table->string('key')->comment('アクションキー');
      $table->string('label_name')->comment('アクション名');
      $table->text('template_message')->comment('テンプレートメッセージ');
      $table->boolean('is_notify')->default(0)->comment('ユーザが通知設定の画面で変更できるか');
      $table->string('link')->comment('リンク');
      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('action_types');
  }
}
