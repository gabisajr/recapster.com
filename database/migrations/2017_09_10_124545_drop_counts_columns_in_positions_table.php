<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropCountsColumnsInPositionsTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::table('positions', function (Blueprint $table) {
      $table->dropColumn('salaries_count', 'reviews_count', 'interviews_count', 'jobs_count');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::table('positions', function (Blueprint $table) {
      $table->unsignedInteger('salaries_count')->default(0)->comment("количество одобренных зарплат")->after('slug');
      $table->unsignedInteger('reviews_count')->default(0)->comment("количество одобренных отзывов")->after('salaries_count');
      $table->unsignedInteger('interviews_count')->default(0)->comment("количество одобренных собеседований")->after('reviews_count');
      $table->unsignedInteger('jobs_count')->default(0)->comment()->comment("количество активных вакансий")->after('interviews_count');
    });
  }
}
