<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignToAdmins extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('admins', function (Blueprint $table) {
      $table->string('department_code')->nullable()->after('id')->comment('部署ID');
      $table->foreign('department_code')->references('department_code')->on('departments')
        ->onUpdate('cascade')->onDelete('no action');
      $table->foreign('role_id')->references('id')->on('roles')
        ->onUpdate('cascade')->onDelete('no action');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('admins', function (Blueprint $table) {
      $table->dropForeign('admins_department_code_foreign');
      $table->dropForeign('admins_role_id_foreign');
    });
  }
}
