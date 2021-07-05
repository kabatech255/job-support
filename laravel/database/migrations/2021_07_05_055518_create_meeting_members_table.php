<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingMembersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('meeting_members', function (Blueprint $table) {
      $table->id();
      $table->unsignedInteger('member_id')->comment('参加者ID');
      $table->unsignedBigInteger('meeting_record_id')->comment('議事録ID');
      // 物理削除
      $table->timestamps();

      $table->foreign('member_id')->references('login_id')->on('users')->onDelete('no action');
      // 議事録自体が削除されたら参加者レコードもいらない
      $table->foreign('meeting_record_id')->references('id')->on('meeting_records')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('meeting_members', function(Blueprint $table){
      $table->dropForeign('meeting_members_meeting_record_id_foreign');
      $table->dropForeign('meeting_members_member_id_foreign');
    });
    Schema::dropIfExists('meeting_members');
  }
}
