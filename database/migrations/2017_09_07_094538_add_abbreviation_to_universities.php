<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAbbreviationToUniversities extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::table('universities', function (Blueprint $table) {
      $table->string('abbreviation', 20)->nullable()->unique()->after('title');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::table('universities', function (Blueprint $table) {
      $table->dropColumn('abbreviation');
    });
  }
}
