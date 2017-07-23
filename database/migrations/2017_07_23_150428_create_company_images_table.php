<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyImagesTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('company_images', function (Blueprint $table) {

      //ссылка на компанию
      $table->unsignedInteger('company_id');
      $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade')->onUpdate('cascade');

      //ссылка на картинку
      $table->unsignedInteger('image_id');
      $table->foreign('image_id')->references('id')->on('images')->onDelete('cascade')->onUpdate('cascade');

      //сортировка
      $table->unsignedInteger('sort')->default(0);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('company_images');
  }
}
