<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUniversitiesTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('universities', function (Blueprint $table) {
      $table->increments('id');
      $table->string('alias', 50)->unique();
      $table->string('title');
      $table->string('site')->unique();

      //ссылка на страну
      $table->unsignedInteger('country_id')->nullable();
      $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null')->onUpdate('cascade');

      //ссылка на город
      $table->unsignedInteger('city_id')->nullable();
      $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null')->onUpdate('cascade');

      //ссылка на логотип
      $table->unsignedInteger('logo_id')->nullable();
      $table->foreign('logo_id')->references('id')->on('images')->onDelete('set null')->onUpdate('cascade');

      //id университета ВКонтакте
      $table->unsignedInteger('vk_id')->nullable()->unique()->comment("id университета ВКонтакте");

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('universities');
  }
}
