<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatReportsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('chat_reports', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('chat_message_id')->comment('チャットメッセージID');
      $table->unsignedBigInteger('created_by')->comment('報告者');
      $table->unsignedBigInteger('report_category_id')->comment('報告の種類');
      $table->timestamps();
      $table->softDeletes();

      $table->foreign('chat_message_id')->references('id')->on('chat_messages')
        ->onUpdate('cascade')
        ->onDelete('cascade');

      $table->foreign('created_by')->references('id')->on('users')
        ->onUpdate('cascade')
        ->onDelete('no action');

      $table->foreign('report_category_id')->references('id')->on('report_categories')
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
    Schema::table('chat_reports', function (Blueprint $table) {
      $table->dropForeign('chat_reports_report_category_id_foreign');
      $table->dropForeign('chat_reports_created_by_foreign');
      $table->dropForeign('chat_reports_chat_message_id_foreign');
    });

    Schema::dropIfExists('chat_reports');
  }
}
