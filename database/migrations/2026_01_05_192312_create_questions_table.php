<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

  public function up(): void {

    Schema::create('questions', function (Blueprint $table) {
      $table->id();
      $table->foreignId('questionnaire_id')->constrained()->cascadeOnDelete();
      $table->string('key'); // e.g. risk_tolerance
      $table->string('label');
      $table->enum('type', ['scale', 'choice', 'text'])->default('scale');
      $table->unsignedInteger('step')->default(1); // pour wizard
      $table->unsignedInteger('weight')->default(1);
      $table->timestamps();

      $table->unique(['questionnaire_id', 'key']);
    });
  }
  
  public function down(): void {
    Schema::dropIfExists('questions');
  }
};