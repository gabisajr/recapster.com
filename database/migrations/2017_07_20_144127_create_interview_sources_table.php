<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterviewSourcesTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('interview_sources', function (Blueprint $table) {
      $table->increments('id');
      $table->string('title')->unique()->comment('название источника');
      $table->unsignedInteger('sort')->default(0)->comment('сортировка');
      $table->boolean('specifiable')->default(false)->comment('источник может иметь уточнение');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('interview_sources');
  }
}
