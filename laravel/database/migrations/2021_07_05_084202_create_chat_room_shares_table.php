<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatRoomSharesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('chat_room_shares', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('chat_room_id')->comment('ルームID');
      $table->unsignedBigInteger('shared_with')->comment('共有相手');
      $table->unsignedBigInteger('shared_by')->comment('共有した人');
      // 物理削除
      $table->timestamps();

      $table->foreign('chat_room_id')->references('id')->on('chat_rooms')
        ->onUpdate('cascade')
        ->onDelete('cascade');
      $table->foreign('shared_with')->references('id')->on('users')
        ->onUpdate('cascade')
        ->onDelete('no action');
      $table->foreign('shared_by')->references('id')->on('users')
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
    Schema::table('chat_room_shares', function(Blueprint $table){
      $table->dropForeign('chat_room_shares_chat_room_id_foreign');
    });
    Schema::table('chat_room_shares', function(Blueprint $table){
      $table->dropForeign('chat_room_shares_shared_with_foreign');
    });
    Schema::table('chat_room_shares', function(Blueprint $table){
      $table->dropForeign('chat_room_shares_shared_by_foreign');
    });
    Schema::dropIfExists('chat_room_shares');
  }
}
