<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameAliasToSlugInCompaniesTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::table('companies', function (Blueprint $table) {
      $table->renameColumn('alias', 'slug');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::table('companies', function (Blueprint $table) {
      $table->renameColumn('slug', 'alias');
    });
  }
}