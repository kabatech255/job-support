<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingRecordsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('meeting_records', function (Blueprint $table) {
      $table->id();
      $table->unsignedInteger('recorded_by')->comment('議事録作成者');
      $table->unsignedInteger('updated_by')->nullable()->comment('議事録更新者');
      $table->unsignedInteger('deleted_by')->nullable()->comment('議事録削除者');
      $table->unsignedBigInteger('place_id')->comment('開催場所');
      $table->dateTime('meeting_date')->comment('開催日');
      $table->string('title')->comment('会議名');
      $table->text('summary')->nullable()->comment('ミーティング概要');

      $table->timestamps();
      $table->softDeletes();

      $table->foreign('recorded_by')->references('login_id')->on('users')
        ->onUpdate('cascade')
        ->onDelete('no action');
      $table->foreign('updated_by')->references('login_id')->on('users')
        ->onUpdate('cascade')
        ->onDelete('no action');
      $table->foreign('deleted_by')->references('login_id')->on('users')
        ->onUpdate('cascade')
        ->onDelete('no action');
      $table->foreign('place_id')->references('id')->on('meeting_places')->onDelete('no action');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('meeting_records', function(Blueprint $table){
      $table->dropForeign('meeting_records_place_id_foreign');
      $table->dropForeign('meeting_records_deleted_by_foreign');
      $table->dropForeign('meeting_records_updated_by_foreign');
      $table->dropForeign('meeting_records_recorded_by_foreign');
    });
    Schema::dropIfExists('meeting_records');
  }
}
