<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleSharesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('schedule_shares', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('schedule_id')->comment('スケジュールID');
      $table->unsignedBigInteger('shared_with')->comment('共有相手');
      $table->unsignedBigInteger('shared_by')->comment('共有した人');
      $table->boolean('is_editable')->default(0)->comment('編集権限');
      // 物理削除
      $table->timestamps();

      $table->foreign('schedule_id')->references('id')->on('schedules')
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
    Schema::table('schedule_shares', function(Blueprint $table){
      $table->dropForeign('schedule_shares_shared_with_foreign');
      $table->dropForeign('schedule_shares_shared_by_foreign');
      $table->dropForeign('schedule_shares_schedule_id_foreign');
    });
    Schema::dropIfExists('schedule_shares');
  }
}
