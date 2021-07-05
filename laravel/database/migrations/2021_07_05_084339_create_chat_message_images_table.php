<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatMessageImagesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('chat_message_images', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('chat_message_id')->comment('チャットID');
      $table->string('file_path')->comment('ファイルパス');

      $table->timestamps();
      $table->softDeletes();
      $table->foreign('chat_message_id')->references('id')->on('chat_messages')
        ->onUpdate('cascade')
        ->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('chat_message_images', function(Blueprint $table){
      $table->dropForeign('chat_message_images_chat_message_id_foreign');
    });
    Schema::dropIfExists('chat_message_images');
  }
}
