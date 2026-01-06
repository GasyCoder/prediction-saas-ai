<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CatalogController;
use App\Http\Controllers\Api\PredictionController;
use App\Http\Controllers\Api\FakePaymentController;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::get('/categories', [CatalogController::class, 'categories']);
Route::get('/categories/{slug}/questionnaire', [CatalogController::class, 'activeQuestionnaire']);

Route::middleware('auth:sanctum')->group(function () {
  Route::get('/me', [AuthController::class, 'me']);
  Route::post('/auth/logout', [AuthController::class, 'logout']);

  Route::post('/predictions', [PredictionController::class, 'create']);
  Route::post('/predictions/{id}/answers', [PredictionController::class, 'saveAnswers']);
  Route::post('/predictions/{id}/checkout', [PredictionController::class, 'checkout']);
  Route::post('/predictions/{id}/run', [PredictionController::class, 'run']);
  Route::get('/predictions/{id}', [PredictionController::class, 'get']);
  Route::get('/predictions', [PredictionController::class, 'history']);

  Route::post('/payments/fake/initiate', [FakePaymentController::class, 'initiate']);
});

// Webhook: pas d’auth user, mais signature HMAC
Route::post('/payments/fake/webhook', [FakePaymentController::class, 'webhook']);
