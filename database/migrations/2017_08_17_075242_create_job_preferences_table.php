<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobPreferencesTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('job_preferences', function (Blueprint $table) {
      $table->increments('id');

      //пользователь
      $table->unsignedInteger('user_id')->comment('id пользователя');
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

      //должность
      $table->unsignedInteger('position_id')->nullable()->comment('id должности');
      $table->foreign('position_id')->references('id')->on('positions')->onDelete('set null')->onUpdate('cascade');
      $table->string('position_title')->nullable()->comment('название должности');

      //город
      $table->unsignedInteger('city_id')->nullable()->comment('id города');
      $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null')->onUpdate('cascade');
      $table->string('city_title')->nullable()->comment('название города');

      //зарплата
      $table->decimal('salary', 19, 2)->nullable()->comment('желаемая зарплата');

      //валюта зарплата
      $table->unsignedInteger('currency_id')->nullable()->comment("валюта зарплаты");
      $table->foreign('currency_id')->references('id')->on("currencies")->onDelete('set null')->onUpdate('cascade');

      $table->boolean('ready_move')->nullable()->comment('готов к переезду');

      //настройки уведомлений
      $table->boolean('notify_email')->default(true)->comment('отправлять ли уведомления о подходящих вакансиях по почте');
      $table->boolean('notify_vk')->default(true)->comment('отправлять ли уведомления о подходящих вакансиях во ВКонтакте');

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('job_preferences');
  }
}
