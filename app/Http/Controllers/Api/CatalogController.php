<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PredictionCategory;
use App\Models\Questionnaire;

class CatalogController extends Controller
{
  public function categories()
  {
    return PredictionCategory::query()->orderBy('name')->get();
  }

  public function activeQuestionnaire(string $slug)
  {
    $cat = PredictionCategory::where('slug', $slug)->firstOrFail();
    $q = Questionnaire::where('prediction_category_id', $cat->id)
      ->where('is_active', true)
      ->latest('version')
      ->with(['questions.options'])
      ->firstOrFail();

    return response()->json([
      'category' => $cat,
      'questionnaire' => $q,
    ]);
  }
}
