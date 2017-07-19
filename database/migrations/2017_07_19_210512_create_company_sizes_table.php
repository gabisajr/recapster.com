<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanySizesTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('company_sizes', function (Blueprint $table) {
      $table->increments('id');
      $table->string('alias', 50)->unique();
      $table->string('employees_count')->nullable()->unique();
      $table->unsignedInteger('sort')->default(0);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('company_sizes');
  }

}
