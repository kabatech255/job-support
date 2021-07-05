<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('admins', function (Blueprint $table) {
      $table->id();
      $table->unsignedInteger('login_id')->unique()->comment('ログインID');
      $table->unsignedInteger('created_by')->nullable()->comment('登録者');
      $table->unsignedInteger('updated_by')->nullable()->comment('更新者');
      $table->unsignedInteger('deleted_by')->nullable()->comment('削除者');
      $table->string('last_name')->comment('姓');
      $table->string('first_name')->comment('名');
      $table->string('last_name_kana')->nullable()->comment('セイ');
      $table->string('first_name_kana')->nullable()->comment('メイ');
      $table->string('file_name')->nullable()->comment('画像');
      $table->string('email')->unique();
      $table->timestamp('email_verified_at')->nullable();
      $table->string('password');
      $table->rememberToken();

      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('admins');
  }
}
