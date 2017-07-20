<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePositionsTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('positions', function (Blueprint $table) {
      $table->increments('id');
      $table->string("title");
      $table->string('alias')->unique()->comment("альяс для ссылки");
      $table->unsignedInteger('salaries_count')->default(0)->comment("количество одобренных зарплат");
      $table->unsignedInteger('reviews_count')->default(0)->comment("количество одобренных отзывов");
      $table->unsignedInteger('interviews_count')->default(0)->comment("количество одобренных собеседований");
      $table->unsignedInteger('jobs_count')->default(0)->comment()->comment("количество активных вакансий");
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('positions');
  }
}
