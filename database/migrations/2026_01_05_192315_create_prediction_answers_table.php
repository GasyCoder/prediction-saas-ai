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
    Schema::create('prediction_answers', function (Blueprint $table) {
      $table->id();
      $table->foreignId('prediction_request_id')->constrained()->cascadeOnDelete();
      $table->foreignId('question_id')->constrained()->cascadeOnDelete();
      $table->text('value'); // string/number/json
      $table->timestamps();

      $table->unique(['prediction_request_id', 'question_id']);
    });
  }
  public function down(): void {
    Schema::dropIfExists('prediction_answers');
  }
};
