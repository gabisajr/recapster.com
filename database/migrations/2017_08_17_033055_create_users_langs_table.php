<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersLangsTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('users_langs', function (Blueprint $table) {

      //пользователь
      $table->unsignedInteger('user_id')->comment("id пользователя");
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

      //язык
      $table->unsignedInteger('lang_id')->comment('id языка');
      $table->foreign('lang_id')->references('id')->on('langs')->onDelete('cascade')->onUpdate('cascade');

      //уникальность пары: user_id + lang_id
      $table->unique(['user_id', 'lang_id']);

      //уровень владения: от 1 - до 5
      $table->unsignedTinyInteger('level')->nullable()->comment('уровень владения (от 1 до 5)');

    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('users_langs');
  }
}
