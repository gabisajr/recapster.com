<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPositionToUsersTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::table('users', function (Blueprint $table) {

      //reference to positions table
      $table->unsignedInteger('position_id')->after('sex')->nullable()->comment('должность или профессия пользователя');
      $table->foreign('position_id')->references('id')->on('positions')->onDelete('set null')->onUpdate('cascade');

      $table->string('position_title')->after('position_id')->nullable()->comment('должность или профессия пользователя (без привязки)');

    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::table('users', function (Blueprint $table) {
      $table->dropForeign(['position_id']);
      $table->dropColumn(['position_id', 'position_title']);
    });
  }
}
