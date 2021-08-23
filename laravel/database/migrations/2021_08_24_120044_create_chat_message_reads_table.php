<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatMessageReadsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('chat_message_reads', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('chat_message_id')->comment('チャットメッセージID');
      $table->unsignedBigInteger('member_id')->comment('ユーザID');
      $table->timestamps();

      $table->foreign('chat_message_id')->references('id')->on('chat_messages')
        ->onUpdate('cascade')
        ->onDelete('cascade');
      $table->foreign('member_id')->references('id')->on('users')
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
    Schema::table('chat_message_reads', function (Blueprint $table) {
      $table->dropForeign('chat_message_reads_chat_message_id_foreign');
      $table->dropForeign('chat_message_reads_member_id_foreign');
    });

    Schema::dropIfExists('chat_message_reads');
  }
}
