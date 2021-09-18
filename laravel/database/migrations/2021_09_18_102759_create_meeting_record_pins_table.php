<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingRecordPinsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('meeting_record_pins', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id')->comment('ピン留めしたユーザID');
      $table->unsignedBigInteger('meeting_record_id')->commnet('議事録ID');
      $table->timestamps();

      $table->foreign('user_id')
        ->references('id')
        ->on('users')
        ->onUpdate('cascade')
        ->onDelete('cascade');

      $table->foreign('meeting_record_id')
        ->references('id')
        ->on('meeting_records')
        ->onUpdate('cascade')
        ->onDelete('cascade');
    });
  }

  /**
   * @return void
   */
  public function down()
  {
    Schema::table('meeting_record_pins', function (Blueprint $table) {
      $table->dropForeign('meeting_record_pins_meeting_record_id_foreign');
      $table->dropForeign('meeting_record_pins_user_id_foreign');
    });
    Schema::dropIfExists('meeting_record_pins');
  }
}
