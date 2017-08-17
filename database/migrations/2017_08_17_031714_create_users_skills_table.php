<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersSkillsTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('users_skills', function (Blueprint $table) {

      //пользователь
      $table->unsignedInteger('user_id')->comment("id пользователя");
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

      //скилл
      $table->unsignedInteger('skill_id')->comment('id скилла');
      $table->foreign('skill_id')->references('id')->on('skills')->onDelete('cascade')->onUpdate('cascade');

      //уникальность пары: user_id + skill_id
      $table->unique(['user_id', 'skill_id']);

      //порядок скиллов
      $table->unsignedInteger('sort')->default(0)->comment('сортировка');

    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('users_skills');
  }
}
