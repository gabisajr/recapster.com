<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyIndustriesTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('company_industries', function (Blueprint $table) {

      //ссылка на компанию
      $table->unsignedInteger('company_id');
      $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade')->onUpdate('cascade');

      //ссылка на направление деятельсности (индустрия)
      $table->unsignedInteger('industry_id');
      $table->foreign('industry_id')->references('id')->on('industries')->onDelete('cascade')->onUpdate('cascade');

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
    Schema::dropIfExists('company_industries');
  }
}
