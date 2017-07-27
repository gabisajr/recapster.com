<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMorpherTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('morpher', function (Blueprint $table) {

      $table->string('И')->unique()->comment("именительный");
      $table->string('Р')->nullable()->comment("родительный");
      $table->string('Д')->nullable()->comment("дательный");
      $table->string('В')->nullable()->comment("винительный");
      $table->string('Т')->nullable()->comment("творительный");
      $table->string('П')->nullable()->comment("предложный");
      $table->string('МИ')->nullable()->comment("(множественное) именительный");
      $table->string('МР')->nullable()->comment("(множественное) родительный");
      $table->string('МД')->nullable()->comment("(множественное) дательный");
      $table->string('МВ')->nullable()->comment("(множественное) винительный");
      $table->string('МТ')->nullable()->comment("(множественное) творительный");
      $table->string('МП')->nullable()->comment("(множественное) предложный");

      $table->primary('И');

      $table->boolean('approved')->default(false)->comment("одобрен ли");

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('morpher');
  }
}
