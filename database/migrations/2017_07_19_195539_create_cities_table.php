<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('cities', function (Blueprint $table) {
      $table->increments('id');
      $table->string('alias')->nullable()->unique();
      $table->string('title')->comment("название города");

      //ссылка на страну
      $table->unsignedInteger('country_id')->nullable();
      $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null')->onUpdate('cascade');

      //ссылка на регион
      $table->unsignedInteger('region_id')->nullable();
      $table->foreign('region_id')->references('id')->on('regions')->onDelete('set null')->onUpdate('cascade');

      //id города ВКонтакте
      $table->unsignedInteger('vk_id')->nullable()->unique()->comment("id города ВКонтакте");

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('cities');
  }
}
