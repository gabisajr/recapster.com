<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('images', function (Blueprint $table) {
      $table->increments('id');
      $table->string('path')->unique();
      $table->unsignedInteger('width')->nullable();
      $table->unsignedInteger('height')->nullable();
      $table->unsignedInteger('parent_id')->nullable();
      $table->boolean('optimised')->default(false)->comment('картинка оптимизирована');
      $table->string('modifier')->nullable()->comment('модификатор');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('images');
  }
}
