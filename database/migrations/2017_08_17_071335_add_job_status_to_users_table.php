<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddJobStatusToUsersTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::table('users', function (Blueprint $table) {
      $table->enum('job_status', ['not_search', 'search', 'ready'])->nullable()->comment('статус - готовность к работе')->after('city_id');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::table('users', function (Blueprint $table) {
      $table->dropColumn('job_status');
    });
  }
}
