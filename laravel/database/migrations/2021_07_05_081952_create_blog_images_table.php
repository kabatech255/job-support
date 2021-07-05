<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogImagesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('blog_images', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('blog_id')->comment('ブログID');
      $table->string('file_path')->comment('画像パス');

      $table->timestamps();
      $table->softDeletes();

      $table->foreign('blog_id')->references('id')->on('blogs')
        ->onUpdate('cascade')
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
    Schema::dropIfExists('blog_images');
  }
}
