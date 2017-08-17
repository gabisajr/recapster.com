<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('subscriptions', function (Blueprint $table) {
      $table->increments('id');

      //пользователь (субъект)
      $table->unsignedInteger('user_id')->comment("id пользователя");
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

      //объект подписик (компания, пользователь) //todo create observer for cascade deleting subscriptions on delete objects: company, user...
      $table->unsignedInteger('object_id')->comment('id объекта подписки');
      $table->unsignedInteger('object_type')->comment('тип объекта подписки');

      //уникальность тройки полей
      $table->unique(['user_id', 'object_id', 'object_type']);

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('subscriptions');
  }
}
