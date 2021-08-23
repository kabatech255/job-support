<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReactionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('reactions', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('chat_message_id')->comment('チャットメッセージID');
      $table->unsignedBigInteger('member_id')->comment('ユーザID');
      $table->unsignedBigInteger('facial_expression_id')->comment('表情ID');
      $table->timestamps();

      $table->foreign('chat_message_id')->references('id')->on('chat_messages')
        ->onUpdate('cascade')
        ->onDelete('cascade');
      $table->foreign('member_id')->references('id')->on('users')
        ->onUpdate('cascade')
        ->onDelete('no action');
      $table->foreign('facial_expression_id')->references('id')->on('facial_expressions')
        ->onUpdate('cascade')
        ->onDelete('no action');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('reactions', function (Blueprint $table) {
      $table->dropForeign('reactions_chat_message_id_foreign');
      $table->dropForeign('reactions_member_id_foreign');
      $table->dropForeign('reactions_facial_expression_id_foreign');
    });

    Schema::dropIfExists('reactions');
  }
}
