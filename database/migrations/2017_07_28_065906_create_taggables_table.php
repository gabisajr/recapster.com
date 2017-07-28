<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaggablesTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('taggables', function (Blueprint $table) {

      //ссылка на тег
      $table->unsignedInteger('tag_id')->comment('тег');
      $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade')->onUpdate('cascade');

      //ссылка на тегируемый объект
      $table->unsignedInteger('taggable_id')->comment('объект');

      //тип тегируемого объекта
      $table->string('taggable_type')->comment('тип объекта');

      //сортировка
      $table->unsignedInteger('sort')->default(0);

      //Add a composite unique index.
      $table->unique(['tag_id', 'taggable_id', 'taggable_type']);

    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('taggables');
  }
}
