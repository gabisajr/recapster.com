<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalaryAdditionalPaymentsTypesTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('salary_additional_payments_types', function (Blueprint $table) {
      $table->increments('id');
      $table->string('title')->unique();
      $table->unsignedInteger('sort')->default(0);
      $table->string('periods')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('salary_additional_payments_types');
  }
}
