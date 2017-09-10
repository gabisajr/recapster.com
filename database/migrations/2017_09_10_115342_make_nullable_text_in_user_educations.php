<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeNullableTextInUserEducations extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::table('user_educations', function (Blueprint $table) {
      $table->text('text')
        ->nullable() //make nullable
        ->comment("описание (специализация и достижения)")
        ->change();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::table('user_educations', function (Blueprint $table) {
      $table
        ->text('text')
        ->notNull() //disable nullable
        ->comment("описание (специализация и достижения)")
        ->change();
    });
  }
}
