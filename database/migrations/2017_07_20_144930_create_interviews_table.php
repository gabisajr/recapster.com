<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterviewsTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('interviews', function (Blueprint $table) {
      $table->increments('id');
      $table->string('alias')->unique()->comment('для url');

      //ссылка на компанию
      $table->unsignedInteger('company_id')->comment("компания");
      $table->foreign('company_id')->references('id')->on("companies")->onDelete('cascade')->onUpdate('cascade');

      $table->enum('status', ['approved', 'pending', 'rejected'])->default('pending');
      $table->unsignedTinyInteger('process_experience')->nullable()->comment('впечатление от собеседования: 1 - позитивное, 2 - нейтральное, 3 - негативное');
      $table->text('description')->nullable()->comment('описание процесса собеседования');
      $table->unsignedTinyInteger('difficulty')->nullable()->comment('сложность 1-5');
      $table->unsignedTinyInteger('interview_outcome')->nullable()->comment('результат собеседования: 1 - да; 2 - да, но отказался; 3 - нет');

      //длительность собеседования
      $table->enum('duration_unit', ['day', 'week', 'month'])->nullable()->comment('длительность процесса, ед измер');
      $table->unsignedTinyInteger('duration_value')->nullable()->comment('длительность процесса, значение');

      //когда проходило собеседование
      $table->unsignedTinyInteger('month')->nullable()->comment('когда было, месяц');
      $table->unsignedTinyInteger('year')->nullable()->comment('когда было, год');

      $table->boolean('we_help')->nullable()->comment('помог ли наш сервис');

      //ссылка на пользователя, кто добавил
      $table->unsignedInteger('user_id')->nullable()->comment("пользователь оставивший собеседование");
      $table->foreign('user_id')->references('id')->on("users")->onDelete('set null')->onUpdate('cascade');

      //ссылка на источник собеседования
      $table->unsignedInteger('source_id')->nullable()->comment('источник собеседования');
      $table->foreign('source_id')->references('id')->on("interview_sources")->onDelete('set null')->onUpdate('cascade');
      $table->string('source_specify')->nullable()->comment('уточнение источника собеседования');

      //ссылка на должность
      $table->unsignedInteger('position_id')->nullable()->comment("на какую должность проходило собеседование");
      $table->foreign('position_id')->references('id')->on("positions")->onDelete('set null')->onUpdate('cascade');
      $table->string('position_title')->nullable()->comment("должность респондента - строкой");

      //ссылка на город, местоположения офиса где проходило собеседование
      $table->unsignedInteger('city_id')->nullable()->comment("где проходило собеседование");
      $table->foreign('city_id')->references('id')->on("cities")->onDelete('set null')->onUpdate('cascade');
      $table->string('city_title')->nullable()->comment("местоположение офиса - строкой");

      $table->string('step_other')->nullable()->comment('другой шаг');

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('interviews');
  }
}
