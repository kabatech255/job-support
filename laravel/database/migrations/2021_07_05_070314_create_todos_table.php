<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodosTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('todos', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('meeting_record_id')->nullable()->comment('議事録ID');
      $table->unsignedBigInteger('owner_id')->comment('担当者');
      $table->unsignedBigInteger('created_by')->comment('作成者');
      $table->unsignedBigInteger('priority_id')->nullable()->comment('優先順位ID');
      $table->unsignedBigInteger('progress_id')->nullable()->comment('進捗度ID');
      $table->string('body')->comment('内容');
      $table->dateTime('time_limit')->comment('期日');

      $table->timestamps();
      $table->softDeletes();

      $table->foreign('meeting_record_id')->references('id')->on('meeting_records')
        ->onUpdate('cascade')
        ->onDelete('no action');
      $table->foreign('owner_id')->references('id')->on('users')
        ->onUpdate('cascade')
        ->onDelete('no action');
      $table->foreign('created_by')->references('id')->on('users')
        ->onUpdate('cascade')
        ->onDelete('no action');
      $table->foreign('priority_id')->references('id')->on('priorities')
        ->onUpdate('cascade')
        ->onDelete('set null');
      $table->foreign('progress_id')->references('id')->on('progress')
        ->onUpdate('cascade')
        ->onDelete('set null');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('todos', function(Blueprint $table){
      $table->dropForeign('todos_priority_id_foreign');
      $table->dropForeign('todos_progress_id_foreign');
      $table->dropForeign('todos_created_by_foreign');
      $table->dropForeign('todos_owner_id_foreign');
      $table->dropForeign('todos_meeting_record_id_foreign');
    });
    Schema::dropIfExists('todos');
  }
}
