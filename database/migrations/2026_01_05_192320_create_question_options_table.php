<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {

  public function up(): void {

    Schema::create('question_options', function (Blueprint $table) {
      $table->id();
      $table->foreignId('question_id')->constrained()->cascadeOnDelete();
      $table->string('value');   // e.g. "team"
      $table->string('label');   // e.g. "Travail en équipe"
      $table->integer('score')->default(0);
      $table->timestamps();

      $table->unique(['question_id', 'value']);
    });
  }
  
  public function down(): void {
    Schema::dropIfExists('question_options');
  }
};
