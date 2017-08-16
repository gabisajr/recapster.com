<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserExperiencesTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('user_experiences', function (Blueprint $table) {
      $table->increments('id');

      //должность
      $table->string("position_title")->nullable()->comment("название должности (без привязки)");
      $table->unsignedInteger('position_id')->nullable()->comment("id должности");
      $table->foreign('position_id')->references('id')->on('positions')->onDelete('set null')->onUpdate('cascade');

      //компания
      $table->string('company_title')->nullable()->comment("название компании (без привязки)");
      $table->unsignedInteger('company_id')->nullable()->comment("id компании");
      $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null')->onUpdate('cascade');

      //город
      $table->string('city_title')->nullable()->comment("название города (без привязки)");
      $table->unsignedInteger('city_id')->nullable()->comment("id города");
      $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null')->onUpdate('cascade');

      //период (начало)
      $table->addColumn('tinyInteger', 'start_month', ['lenght' => 2, 'comment' => 'начало работы, месяц', 'unsigned' => true]);
      $table->addColumn('tinyInteger', 'start_year', ['lenght' => 4, 'comment' => 'начало работы, год', 'unsigned' => true]);

      //период (окончание)
      $table->addColumn('tinyInteger', 'end_month', ['lenght' => 2, 'comment' => 'окончание работы, месяц', 'unsigned' => true]);
      $table->addColumn('tinyInteger', 'end_year', ['lenght' => 4, 'comment' => 'окончание работы, год', 'unsigned' => true]);

      $table->boolean('is_current')->default(false)->comment("работает по настоящее время");
      $table->boolean('is_internship')->nullable()->comment("является ли стажировкой");
      $table->text('text')->nullable()->comment('обязанности и достижения');

      //пользователь
      $table->unsignedInteger('user_id')->comment("id пользователя");
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('user_experiences');
  }
}
