<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChairsTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('chairs', function (Blueprint $table) {
      $table->increments('id');
      $table->string('title');

      //ссылка на факультет
      $table->unsignedInteger('faculty_id')->nullable();
      $table->foreign('faculty_id')->references('id')->on('faculties')->onDelete('cascade')->onUpdate('cascade');

      //id кафедры ВКонтакте
      $table->unsignedInteger('vk_id')->nullable()->unique()->comment("id кафедры ВКонтакте");

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('chairs');
  }
}
