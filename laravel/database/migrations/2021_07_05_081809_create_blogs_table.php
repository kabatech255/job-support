<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('blogs', function (Blueprint $table) {
      $table->id();
      $table->unsignedInteger('written_by')->comment('投稿者');
      $table->unsignedBigInteger('role_id')->comment('閲覧権限');
      $table->string('title')->comment('タイトル');
      $table->text('body')->comment('本文');

      $table->timestamps();
      $table->softDeletes();

      $table->foreign('written_by')->references('login_id')->on('users')
        ->onUpdate('cascade')
        ->onDelete('no action');
      $table->foreign('role_id')->references('id')->on('roles')
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
    Schema::table('blogs', function(Blueprint $table){
      $table->dropForeign('blogs_role_id_foreign');
      $table->dropForeign('blogs_written_by_foreign');
    });
    Schema::dropIfExists('blogs');
  }
}
