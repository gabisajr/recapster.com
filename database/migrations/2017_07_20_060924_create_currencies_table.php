<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrenciesTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('currencies', function (Blueprint $table) {
      $table->increments('id');
      $table->string('code', 3)->unique();
      $table->string('title')->unique();
      $table->string('symbol', 1)->nullable()->comment("символ волюты");
      $table->string("short", 5)->nullable()->comment("сокращеное название (тг, руб)");
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('currencies');
  }
}
