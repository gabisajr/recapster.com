<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegionsTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('regions', function (Blueprint $table) {
      $table->increments('id');
      $table->string('title');
      $table->string('short_title')->nullable();

      //ссылка на страну
      $table->unsignedInteger('country_id')->nullable();
      $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade')->onUpdate('cascade');

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('regions');
  }
}
