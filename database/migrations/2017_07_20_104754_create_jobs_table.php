<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('jobs', function (Blueprint $table) {
      $table->increments('id');
      $table->string('title')->comment("заголовок");

      //ссылка на должность
      $table->unsignedInteger('position_id')->nullable()->comment("должность");
      $table->foreign('position_id')->references('id')->on("positions")->onDelete('set null')->onUpdate('cascade');

      //ссылка на форму занятости
      $table->string('employment_form_id')->nullable()->comment("форма занятости");
      $table->foreign('employment_form_id')->references('id')->on("employment_forms")->onDelete('set null')->onUpdate('cascade');

      //ссылка на стаж работы
      $table->unsignedInteger('stage_id')->nullable()->comment("опыт работы");
      $table->foreign('stage_id')->references('id')->on("stages")->onDelete('set null')->onUpdate('cascade');

      //зарплата
      $table->float('salary_min')->nullable()->comment("мин зарплата");
      $table->float('salary_max')->nullable()->comment("макс зарплата");

      $table->boolean('has_additional_payments')->default(false)->comment("есть ли дополнительные выплаты");

      //ссылка на валюту
      $table->string('currency_code', 3)->nullable()->comment("валюта зарплаты");
      $table->foreign('currency_code')->references('code')->on("currencies")->onDelete('set null')->onUpdate('cascade');

      $table->string('description')->nullable()->comment("описание");

      //ссылка на компанию
      $table->unsignedInteger('company_id')->comment("компания");
      $table->foreign('company_id')->references('id')->on("companies")->onDelete('cascade')->onUpdate('cascade');

      //ссылка на пользователя
      $table->unsignedInteger('user_id')->nullable()->comment("пользователь создавший вакансию");
      $table->foreign('user_id')->references('id')->on("users")->onDelete('set null')->onUpdate('cascade');

      //статус
      $table->enum('status', ["approved", "pending", "rejected", "draft"])->default("draft")
        ->comment("статус вакансии: approved - одобрена, pending - в ожинании, rejected - отконена, draft - черновик");

      $table->boolean('is_internship')->default(false)->comment("является ли стажировкой");
      $table->boolean('hot')->default(false)->comment("горячая вакансия");
      $table->string('external_url')->nullable()->comment("внешняя ссылка на вакансию");
      $table->enum('apply_type', ['external', 'contacts', 'internal'])->nullable()->comment("тип отклика: переход по внешней по ссылке, показать контакты, внутренняя");
      $table->text('contacts')->nullable()->comment("контактные данные");

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('jobs');
  }
}
