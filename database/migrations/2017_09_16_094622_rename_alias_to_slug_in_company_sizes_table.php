<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameAliasToSlugInCompanySizesTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::table('company_sizes', function (Blueprint $table) {
      $table->renameColumn('alias', 'slug');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::table('company_sizes', function (Blueprint $table) {
      $table->renameColumn('slug', 'alias');
    });
  }
}
