<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsCitiesTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('jobs_cities', function (Blueprint $table) {

      //ссылка на вакансию
      $table->unsignedInteger('job_id')->comment('вакансия');
      $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade')->onUpdate('cascade');

      //ссылка на город
      $table->unsignedInteger('city_id')->comment('город');
      $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade')->onUpdate('cascade');

      //сортировка
      $table->unsignedInteger('sort')->default(0);

      //Add a composite unique index.
      $table->unique(['job_id', 'city_id']);

    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('jobs_cities');
  }
}
