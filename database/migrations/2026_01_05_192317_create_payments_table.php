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
    Schema::create('payments', function (Blueprint $table) {
      $table->id();
      $table->foreignId('prediction_request_id')->constrained()->cascadeOnDelete();
      $table->string('provider')->default('fake');
      $table->enum('status', ['initiated','succeeded','failed'])->default('initiated');
      $table->string('tx_ref')->unique();
      $table->json('meta')->nullable();
      $table->timestamps();
    });
  }
  public function down(): void {
    Schema::dropIfExists('payments');
  }
};
