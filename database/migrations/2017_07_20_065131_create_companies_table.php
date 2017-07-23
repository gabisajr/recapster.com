<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('companies', function (Blueprint $table) {
      $table->increments('id');
      $table->string('alias');
      $table->string('title');
      $table->float('rating')->default(0);

      //ссылка на пользователя, кто добавил
      $table->unsignedInteger('created_user_id')->nullable();
      $table->foreign('created_user_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');

      //ссылка на пользователя, кто сделал последнее обновление
      $table->unsignedInteger('updated_user_id')->nullable();
      $table->foreign('updated_user_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');

      //ссылка на логотип
      $table->unsignedInteger('logo_id')->nullable();
      $table->foreign('logo_id')->references('id')->on('images')->onDelete('set null')->onUpdate('cascade');

      //ссылка на обложку
      $table->unsignedInteger('cover_id')->nullable();
      $table->foreign('cover_id')->references('id')->on('images')->onDelete('set null')->onUpdate('cascade');

      $table->string('site')->nullable();
      $table->text('short_desc')->nullable()->comment("короткое описание компании");

      //ссылка на размер
      $table->unsignedInteger('size_id')->nullable()->comment("размер компании (кол-во сотрудников)");
      $table->foreign('size_id')->references('id')->on('company_sizes')->onDelete('set null')->onUpdate('cascade');

      //доход компании
      $table->unsignedInteger('revenue_id')->nullable()->comment("доход компании");
      $table->foreign('revenue_id')->references('id')->on('company_revenues')->onDelete('set null')->onUpdate('cascade');

      //ссылка на город, в котором находится головной офис компании
      $table->unsignedInteger('hq_city_id')->nullable()->comment("город где находится головной офис");
      $table->foreign('hq_city_id')->references('id')->on('cities')->onDelete('set null')->onUpdate('cascade');

      $table->unsignedSmallInteger('foundation_year')->nullable()->comment("год основания");
      $table->string('description', 1000)->comment("описание компании");
      $table->boolean('confirmed')->default(false)->comment("подтвержденый аккаунт");
      $table->boolean('active')->default(false)->comment("активированая компания");
      $table->unsignedInteger('reviews_count')->default(0)->comment("количество активных отзывов");
      $table->unsignedInteger('salaries_count')->default(0)->comment("количество активных зарплат");
      $table->unsignedInteger('interviews_count')->default(0)->comment("количество активных собеседований");
      $table->unsignedInteger('jobs_count')->default(0)->comment("количество вакансий");
      $table->unsignedInteger('internship_count')->default(0)->comment("количество стажировок");
      $table->unsignedInteger('benefits_count')->default(0)->comment("количество активных приемуществ");
      $table->unsignedInteger('images_count')->default(0)->comment("количество активных фотографий");
      $table->unsignedInteger('followers_count')->default(0)->comment("количество подписчиков");
      $table->string('tel', 30)->nullable()->comment("телефон");
      $table->unsignedInteger("vk_group_id")->nullable()->comment("id группы ВКонтакте");

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('companies');
  }
}
