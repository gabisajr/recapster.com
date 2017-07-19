<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacultiesTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('faculties', function (Blueprint $table) {
      $table->increments('id');
      $table->string('title');

      //ссылка на университет
      $table->unsignedInteger('university_id')->nullable();
      $table->foreign('university_id')->references('id')->on('universities')->onDelete('cascade')->onUpdate('cascade');

      //id факультета ВКонтакте
      $table->unsignedInteger('vk_id')->nullable()->unique()->comment("id факультета ВКонтакте");

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('faculties');
  }
}
