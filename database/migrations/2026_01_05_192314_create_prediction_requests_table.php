<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up(): void {
    Schema::create('prediction_requests', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();
      $table->foreignId('prediction_category_id')->constrained()->cascadeOnDelete();
      $table->foreignId('questionnaire_id')->constrained()->cascadeOnDelete();
      $table->enum('status', ['draft','pending_payment','processing','done','failed'])->default('draft');
      $table->unsignedInteger('total_amount')->default(0); // en ariary ou unité fictive
      $table->string('currency')->default('MGA');
      $table->timestamps();
    });
  }
  public function down(): void {
    Schema::dropIfExists('prediction_requests');
  }
};
