<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogLikesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('blog_likes', function (Blueprint $table) {
      $table->id();
      $table->unsignedInteger('liked_by')->comment('いいねした人');
      $table->unsignedBigInteger('blog_id')->comment('ブログID');
      // 物理削除
      $table->timestamps();

      $table->foreign('liked_by')->references('login_id')->on('users')
        ->onUpdate('cascade')
        ->onDelete('no action');
      $table->foreign('blog_id')->references('id')->on('blogs')
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
    Schema::table('blog_likes', function(Blueprint $table){
      $table->dropForeign('blog_likes_blog_id_foreign');
      $table->dropForeign('blog_likes_liked_by_foreign');
    });
    Schema::dropIfExists('blog_likes');
  }
}
