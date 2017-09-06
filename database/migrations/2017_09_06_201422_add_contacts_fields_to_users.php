<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContactsFieldsToUsers extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::table('users', function (Blueprint $table) {
      $table->string('skype')->nullable()->unique()->after('city_id');
      $table->string('instagram')->nullable()->unique()->after('skype');
      $table->string('twitter')->nullable()->unique()->after('instagram');
      $table->string('site')->nullable()->unique()->after('twitter');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::table('users', function (Blueprint $table) {
      $table->dropColumn('skype', 'instagram', 'twitter', 'site');
    });
  }
}
