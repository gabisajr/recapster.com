<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToImagesTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::table('images', function (Blueprint $table) {
      //статус одобрения
      $table->enum('status', ["approved", "pending", "rejected"])->default('pending')->after('modifier')
        ->comment("статус фотографии: approved - одобрена, pending - в ожинании, rejected - отконена");
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::table('images', function (Blueprint $table) {
      $table->dropColumn('status');
    });
  }
}
