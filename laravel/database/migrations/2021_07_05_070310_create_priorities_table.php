<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrioritiesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('priorities', function (Blueprint $table) {
      $table->id();
      $table->string('name')->unique()->comment('優先順位名');
      $table->integer('value')->default(1)->comment('優先値（数値が大きいほど優先度が高い）');

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
    Schema::dropIfExists('priorities');
  }
}
