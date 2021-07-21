<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentSharesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('document_shares', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('shared_with')->comment('共有相手');
      $table->unsignedBigInteger('file_id')->comment('ファイルID');
      $table->unsignedBigInteger('shared_by')->comment('共有者');
      $table->boolean('is_editable')->default(0)->comment('編集権限');
      // 物理削除
      $table->timestamps();

      $table->foreign('shared_with')->references('id')->on('users')
        ->onUpdate('cascade')
        ->onDelete('no action');
      $table->foreign('shared_by')->references('id')->on('users')
        ->onUpdate('cascade')
        ->onDelete('no action');
      $table->foreign('file_id')->references('id')->on('document_files')
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
    Schema::table('document_shares', function(Blueprint $table){
      $table->dropForeign('document_shares_shared_with_foreign');
      $table->dropForeign('document_shares_shared_by_foreign');
      $table->dropForeign('document_shares_file_id_foreign');
    });
    Schema::dropIfExists('document_shares');
  }
}
