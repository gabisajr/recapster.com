<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserEducationsTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('user_educations', function (Blueprint $table) {
      $table->increments('id');

      //ссылка на пользователя
      $table->unsignedInteger('user_id')->comment("пользователь");
      $table->foreign('user_id')->references('id')->on("users")->onDelete('cascade')->onUpdate('cascade');

      //ссылка на университет
      $table->unsignedInteger('university_id')->nullable()->comment("университет");
      $table->foreign('university_id')->references('id')->on("universities")->onDelete('set null')->onUpdate('cascade');

      //факультет
      $table->unsignedInteger('faculty_id')->nullable()->comment("факультет");
      $table->foreign('faculty_id')->references('id')->on("faculties")->onDelete('set null')->onUpdate('cascade');

      //кафедра/направление
      $table->unsignedInteger('chair_id')->nullable()->comment("кафедра/направление");
      $table->foreign('chair_id')->references('id')->on("chairs")->onDelete('set null')->onUpdate('cascade');

      //ссылка на форму образования
      $table->unsignedInteger('edu_form_id')->nullable();
      $table->foreign('edu_form_id')->references('id')->on("education_forms")->onDelete('set null')->onUpdate('cascade');

      //начало обучения
      $table->unsignedSmallInteger('start_year')->nullable()->comment("год начала обучения");
      $table->unsignedTinyInteger('start_month')->nullable()->comment("месяц начала обучения");

      //окончание обучения
      $table->unsignedSmallInteger('end_year')->nullable()->comment("год окончания обучения");
      $table->unsignedTinyInteger('end_month')->nullable()->comment("месяц окончания обучения");

      $table->text('text')->comment("описание (специализация и достижения)");

      $table->string('specialty')->nullable()->comment("специальность");

      //ссылка на статус образования
      $table->unsignedInteger('status_id')->nullable()->comment("статус образования");
      $table->foreign('status_id')->references('id')->on("education_statuses")->onDelete('set null')->onUpdate('cascade');

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('user_educations');
  }
}
