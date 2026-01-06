<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

  public function up(): void {

    Schema::create('questionnaires', function (Blueprint $table) {
      $table->id();
      $table->foreignId('prediction_category_id')->constrained()->cascadeOnDelete();
      $table->unsignedInteger('version')->default(1);
      $table->string('title');
      $table->boolean('is_active')->default(true);
      $table->timestamps();

      $table->unique(['prediction_category_id', 'version']);
    });
  }
  
  public function down(): void {
    Schema::dropIfExists('questionnaires');
  }
};