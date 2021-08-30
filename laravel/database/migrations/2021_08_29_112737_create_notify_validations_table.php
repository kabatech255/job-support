<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotifyValidationsTable extends Migration
{
  /**
   * @return void
   */
  public function up()
  {
    Schema::create('notify_validations', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id')->comment('ユーザID');
      $table->unsignedBigInteger('action_type_id')->comment('アクションID');
      $table->boolean('is_valid')->default(1)->comment('許可・不許可');
      $table->timestamps();

      $table->foreign('user_id')->references('id')->on('users')
        ->onUpdate('cascade')
        ->onDelete('cascade');
      $table->foreign('action_type_id')->references('id')->on('action_types')
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
    Schema::table('notify_validations', function (Blueprint $table) {
      $table->dropForeign('notify_validations_user_id_foreign');
      $table->dropForeign('notify_validations_action_type_id_foreign');
    });

    Schema::dropIfExists('notify_validations');
  }
}
