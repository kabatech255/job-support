<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentFilesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('document_files', function (Blueprint $table) {
      $table->id();
      $table->unsignedInteger('uploaded_by')->comment('アップロード者');
      $table->unsignedBigInteger('folder_id')->comment('フォルダID');
      $table->string('file_path')->comment('ファイルパス');

      $table->timestamps();
      $table->softDeletes();

      $table->foreign('uploaded_by')->references('login_id')->on('users')
        ->onUpdate('cascade')
        ->onDelete('no action');

      $table->foreign('folder_id')->references('id')->on('document_folders')
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
    Schema::table('document_files', function(Blueprint $table){
      $table->dropForeign('document_files_folder_id_foreign');
      $table->dropForeign('document_files_uploaded_by_foreign');
    });
    Schema::dropIfExists('document_files');
  }
}
