<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCeoTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('ceo', function (Blueprint $table) {
      $table->increments('id');
      $table->string('firstname')->nullable();
      $table->string('lastname')->nullable();
      $table->string('title')->nullable();

      //ссылка на аватар
      $table->unsignedInteger('avatar_id')->nullable();
      $table->foreign('avatar_id')->references('id')->on('images')->onDelete('set null')->onUpdate('cascade');

      //ссылка на компанию
      $table->unsignedInteger('company_id')->nullable();
      $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade')->onUpdate('cascade');

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('ceo');
  }
}
