<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCityToUsersTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::table('users', function (Blueprint $table) {
      //reference to cities table
      $table->unsignedInteger('city_id')->nullable()->comment('id города')->after('position_title');
      $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null')->onUpdate('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::table('users', function (Blueprint $table) {
      $table->dropForeign(['city_id']);
      $table->dropColumn(['city_id']);
    });
  }
}
