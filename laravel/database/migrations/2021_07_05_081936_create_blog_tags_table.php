<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogTagsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('blog_tags', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('blog_id')->comment('ブログID');
      $table->unsignedBigInteger('tag_id')->comment('タグID');
      // 物理削除
      $table->timestamps();

      $table->foreign('blog_id')->references('id')->on('blogs')
        ->onDelete('cascade');
      $table->foreign('tag_id')->references('id')->on('tags')
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
    Schema::table('blog_tags', function(Blueprint $table){
      $table->dropForeign('blog_tags_blog_id_foreign');
      $table->dropForeign('blog_tags_tag_id_foreign');
    });
    Schema::dropIfExists('blog_tags');
  }
}
