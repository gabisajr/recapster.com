<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('countries', function (Blueprint $table) {
      $table->increments('id');
      $table->string('title')->unique();
      $table->string('iso_code', 2)->unique()->comment("ISO 3166-1 alpha-2");
      $table->unsignedInteger('vk_id')->unique()->comment("id страны ВКонтакте");
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('countries');
  }
}
