<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBirthToUsersTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::table('users', function (Blueprint $table) {
      DB::statement("ALTER TABLE `users` ADD `birth_day` TINYINT(2) DEFAULT NULL AFTER `job_status`");
      DB::statement("ALTER table `users` ADD  `birth_month` TINYINT(2) DEFAULT NULL AFTER `birth_day`");
      DB::statement('ALTER TABLE `users` ADD `birth_year` YEAR DEFAULT NULL AFTER `birth_month`');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::table('users', function (Blueprint $table) {
      $table->dropColumn(['birth_day', 'birth_month', 'birth_year']);
    });
  }
}
