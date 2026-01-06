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
    Schema::create('prediction_results', function (Blueprint $table) {
      $table->id();
      $table->foreignId('prediction_request_id')->constrained()->cascadeOnDelete();
      $table->json('result_json');
      $table->unsignedInteger('score')->default(0);
      $table->string('confidence_label')->default('indicatif');
      $table->timestamp('generated_at')->nullable();
      $table->timestamps();

      $table->unique('prediction_request_id');
    });
  }
  public function down(): void {
    Schema::dropIfExists('prediction_results');
  }
};
