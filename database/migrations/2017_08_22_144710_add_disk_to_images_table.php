<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDiskToImagesTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::table('images', function (Blueprint $table) {
      $table->string('disk')->nullable()->comment('storage disk name')->after('status');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::table('images', function (Blueprint $table) {
      $table->dropColumn('disk');
    });
  }
}
