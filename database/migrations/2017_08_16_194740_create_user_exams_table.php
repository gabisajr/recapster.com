<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserExamsTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('user_exams', function (Blueprint $table) {
      $table->increments('id');

      $table->string('title')->nullable()->comment('название');
      $table->string('organization')->nullable()->comment('проводившая организация');
      $table->string('specialization')->nullable()->comment('специализация');
      $table->addColumn('tinyInteger', 'year', ['lenght' => 4, 'comment' => 'год', 'unsigned' => true]);

      //user
      $table->unsignedInteger('user_id')->comment("id пользователя");
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('user_exams');
  }
}
