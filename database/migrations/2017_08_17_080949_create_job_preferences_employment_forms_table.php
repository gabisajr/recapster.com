<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobPreferencesEmploymentFormsTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('job_preferences_employment_forms', function (Blueprint $table) {

      //ссылка на предпочтения по работе
      $table->unsignedInteger('job_preferences_id')->comment('id предпочтений работы');
      $table->foreign('job_preferences_id')->references('id')->on('job_preferences')->onDelete('cascade')->onUpdate('cascade');

      //ссылка на форму занятости
      $table->unsignedInteger('employment_form_id')->comment('id формы занятости');
      $table->foreign('employment_form_id')->references('id')->on('employment_forms')->onDelete('cascade')->onUpdate('cascade');

      //уникальность пары: job_preferences_id + employment_form_id
      $table->unique(['job_preferences_id', 'employment_form_id'], 'job_preferences_id_employment_form_id_unique');

    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('job_preferences_employment_forms');
  }
}
