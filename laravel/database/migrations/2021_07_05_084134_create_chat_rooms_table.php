<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatRoomsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('chat_rooms', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('created_by')->comment('作成者');
      $table->string('name')->nullable()->comment('ルーム名');

      $table->timestamps();
      $table->softDeletes();

      $table->foreign('created_by')->references('id')->on('users')
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
    Schema::table('chat_rooms', function(Blueprint $table){
      $table->dropForeign('chat_rooms_created_by_foreign');
    });

    Schema::dropIfExists('chat_rooms');
  }
}
