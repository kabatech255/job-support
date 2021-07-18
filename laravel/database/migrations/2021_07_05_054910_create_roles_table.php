<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('roles', function (Blueprint $table) {
      $table->id();
      $table->string('name')->comment('権限名');
      $table->string('label')->comment('権限名のラベル');
      $table->integer('value')->comment('権限値');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('roles');
  }
}
