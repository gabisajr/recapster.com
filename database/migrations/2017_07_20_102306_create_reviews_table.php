<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('reviews', function (Blueprint $table) {
      $table->increments('id');

      //ссылка на компанию
      $table->unsignedInteger("company_id")->comment("для какой компании отзыв");
      $table->foreign('company_id')->references('id')->on("companies")->onDelete('cascade')->onUpdate('cascade');

      $table->string("text")->comment("текст отзыва");
      $table->boolean("active_employee")->default(true)->comment("отзыв от действующего сотрудника");
      $table->unsignedTinyInteger('rating')->nullable()->comment("общая оценка компании от респондента");

      //ссылка на должность
      $table->unsignedInteger('position_id')->nullable()->comment("должность респондента");
      $table->foreign('position_id')->references('id')->on("positions")->onDelete('set null')->onUpdate('cascade');
      $table->string('position_title')->nullable()->comment("должность респондента - строкой");

      //статус одобрения
      $table->enum('status', ["approved", "pending", "rejected"])->default("pending")->comment("статус отзыва: approved - одобрен, pending - в ожинании, rejected - отконен");

      //ссылка на форму занятости
      $table->string('employment_form_alias')->nullable()->comment("форма занятости");
      $table->foreign('employment_form_alias')->references('alias')->on("employment_forms")->onDelete('set null')->onUpdate('cascade');

      $table->boolean('recommend')->nullable()->comment("рекомендую ли работать");

      //ссылка на стаж работы
      $table->unsignedInteger('stage_id')->nullable()->comment("стаж работы");
      $table->foreign('stage_id')->references('id')->on("stages")->onDelete('set null')->onUpdate('cascade');

      //ссылка на город, местоположения офиса
      $table->unsignedInteger('city_id')->nullable()->comment("местоположение офиса");
      $table->foreign('city_id')->references('id')->on("cities")->onDelete('set null')->onUpdate('cascade');

      $table->string('city_title')->nullable()->comment("местоположение офиса - строкой");

      //ссылка на пользователя, кто добавил
      $table->unsignedInteger('user_id')->nullable()->comment("пользователь оставивший отзыв");
      $table->foreign('user_id')->references('id')->on("users")->onDelete('set null')->onUpdate('cascade');

      $table->boolean('anonym')->default(1)->comment("отзыв является анонимным");

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('reviews');
  }
}
