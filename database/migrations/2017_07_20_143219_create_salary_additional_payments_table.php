<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalaryAdditionalPaymentsTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('salary_additional_payments', function (Blueprint $table) {
      $table->increments('id');

      //ссылка на зарплату
      $table->unsignedInteger('salary_id')->comment("к какой зарплате относится");
      $table->foreign('salary_id')->references('id')->on("salaries")->onDelete('cascade')->onUpdate('cascade');

      //ссылка на тип дополнительной выплаты
      $table->unsignedInteger('type_id')->nullable()->comment("тип выплаты");
      $table->foreign('type_id')->references('id')->on("salary_additional_payments_types")->onDelete('set null')->onUpdate('cascade');

      $table->float('value')->comment('сумма');
      $table->enum('period', ['year', 'month'])->comment('период');

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('salary_additional_payments');
  }
}
