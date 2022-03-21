<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogReportsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('blog_reports', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('blog_id')->comment('ブログID');
      $table->unsignedBigInteger('created_by')->comment('通報者');
      $table->timestamps();
      $table->softDeletes();

      $table->foreign('blog_id')->references('id')->on('blogs')
        ->onUpdate('cascade')
        ->onDelete('cascade');

      $table->foreign('created_by')->references('id')->on('users')
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
    Schema::table('blog_reports', function (Blueprint $table) {
      $table->dropForeign('blog_reports_created_by_foreign');
      $table->dropForeign('blog_reports_blog_id_foreign');
    });
    Schema::dropIfExists('blog_reports');
  }
}
