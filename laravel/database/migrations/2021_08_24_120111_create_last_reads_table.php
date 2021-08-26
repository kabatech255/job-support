<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLastReadsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('last_reads', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('chat_room_id');
      $table->unsignedBigInteger('member_id');
      $table->unsignedBigInteger('last_message_id');
      $table->timestamps();

      $table->foreign('chat_room_id')->references('id')->on('chat_rooms')
        ->onUpdaete('cascade')
        ->onDelete('cascade');
      $table->foreign('member_id')->references('id')->on('users')
        ->onUpdaete('cascade')
        ->onDelete('no action');
      $table->foreign('last_message_id')->references('id')->on('chat_messages')
        ->onUpdaete('cascade')
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
    Schema::table('last_reads', function (Blueprint $table) {
      $table->dropForeign('last_reads_chat_room_id_foreign');
      $table->dropForeign('last_reads_member_id_foreign');
      $table->dropForeign('last_reads_last_message_id_foreign');
    });

    Schema::dropIfExists('last_reads');
  }
}
