<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalariesTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('salaries', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('base_pay')->comment("основная сумма");

      //ссылка на валюту
      $table->string('currency_code', 3)->nullable()->comment("валюта зарплаты");
      $table->foreign('currency_code')->references('code')->on("currencies")->onDelete('set null')->onUpdate('cascade');

      //ссылка на компанию
      $table->unsignedInteger('company_id')->comment("компания");
      $table->foreign('company_id')->references('id')->on("companies")->onDelete('cascade')->onUpdate('cascade');

      $table->enum('employee_status', ['active', 'former'])->nullable()->comment("статус работника: active - действующий, former - бывший");
      $table->unsignedSmallInteger('last_year')->nullable()->comment()->comment("последний год работы для бывшего работника");
      $table->enum('status', ['approved', 'pending', 'rejected'])->default('pending');

      //ссылка на должность
      $table->unsignedInteger('position_id')->nullable()->comment("должность респондента");
      $table->foreign('position_id')->references('id')->on("positions")->onDelete('set null')->onUpdate('cascade');
      $table->string('position_title')->nullable()->comment("должность респондента - строкой");

      //ссылка на пользователя, кто добавил
      $table->unsignedInteger('user_id')->nullable()->comment("пользователь оставивший данные о зарплате");
      $table->foreign('user_id')->references('id')->on("users")->onDelete('set null')->onUpdate('cascade');

      $table->enum('period', ['year', 'month', 'day', 'hour'])->nullable();

      //ссылка на стаж работы
      $table->unsignedInteger('stage_id')->nullable()->comment("стаж работы");
      $table->foreign('stage_id')->references('id')->on("stages")->onDelete('set null')->onUpdate('cascade');

      //ссылка на город, местоположения офиса
      $table->unsignedInteger('city_id')->nullable()->comment("местоположение офиса");
      $table->foreign('city_id')->references('id')->on("cities")->onDelete('set null')->onUpdate('cascade');

      $table->string('city_title')->nullable()->comment("местоположение офиса - строкой");

      //ссылка на форму занятости
      $table->string('employment_form_alias')->nullable()->comment("форма занятости");
      $table->foreign('employment_form_alias')->references('alias')->on("employment_forms")->onDelete('set null')->onUpdate('cascade');

      $table->boolean('has_additional_payments')->nullable()->comment('есть ли дополнительные выплаты: 1 - да, 0 - нет, null - не указал');

      //ссылка на направление деятельности компании
      $table->unsignedInteger('company_industry_id')->nullable()->comment('направление деятельности компании');
      $table->foreign('company_industry_id')->references('id')->on("industries")->onDelete('set null')->onUpdate('cascade');

      //ссылка на размер компании
      $table->unsignedInteger('company_size_id')->nullable()->comment('размер компании');
      $table->foreign('company_size_id')->references('id')->on("company_sizes")->onDelete('set null')->onUpdate('cascade');

      $table->boolean('hidden_employer')->nullable()->comment('флаг скрытый работодатель');

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('salaries');
  }
}
