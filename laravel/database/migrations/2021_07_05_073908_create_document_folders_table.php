<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentFoldersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('document_folders', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('created_by')->comment('作成者');
      $table->unsignedBigInteger('role_id')->nullable()->comment('ロールID');
      $table->string('name')->comment('フォルダ名');
      $table->string('random_name')->comment('ランダムフォルダ名');

      $table->timestamps();
      $table->softDeletes();

      $table->foreign('created_by')->references('id')->on('users')
        ->onUpdate('cascade')
        ->onDelete('no action');

      $table->foreign('role_id')->references('id')->on('roles')
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
    Schema::table('document_folders', function(Blueprint $table){
      $table->dropForeign('document_folders_role_id_foreign');
      $table->dropForeign('document_folders_created_by_foreign');
    });
    Schema::dropIfExists('document_folders');
  }
}
