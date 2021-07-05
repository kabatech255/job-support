<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingPlacesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('meeting_places', function (Blueprint $table) {
      $table->id();
      $table->string('body')->comment('開催場所');
      $table->unsignedInteger('created_by')->nullable()->comment('登録者');
      $table->unsignedInteger('updated_by')->nullable()->comment('更新者');
      $table->unsignedInteger('deleted_by')->nullable()->comment('削除者');

      $table->timestamps();
      $table->softDeletes();

      $table->foreign('created_by')->references('login_id')->on('users')
        ->onUpdate('cascade')
        ->onDelete('no action');
      $table->foreign('updated_by')->references('login_id')->on('users')
        ->onUpdate('cascade')
        ->onDelete('no action');
      $table->foreign('deleted_by')->references('login_id')->on('users')
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
    Schema::table('meeting_places', function(Blueprint $table) {
      $table->dropForeign('meeting_places_deleted_by_foreign');
      $table->dropForeign('meeting_places_updated_by_foreign');
      $table->dropForeign('meeting_places_created_by_foreign');
    });
    Schema::dropIfExists('meeting_places');
  }
}
