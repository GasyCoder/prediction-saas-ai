<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PredictionCategory;
use App\Models\PredictionRequest;
use App\Models\PredictionAnswer;
use App\Models\PredictionResult;
use App\Models\Questionnaire;
use App\Services\PredictionEngine;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PredictionController extends Controller
{
  public function create(Request $request)
  {
    $data = $request->validate([
      'category_slug' => ['required','string'],
    ]);

    $cat = PredictionCategory::where('slug', $data['category_slug'])->firstOrFail();

    $q = Questionnaire::where('prediction_category_id', $cat->id)
      ->where('is_active', true)
      ->latest('version')
      ->firstOrFail();

    $req = PredictionRequest::create([
      'user_id' => $request->user()->id,
      'prediction_category_id' => $cat->id,
      'questionnaire_id' => $q->id,
      'status' => 'draft',
      'total_amount' => 2000, // fake price
      'currency' => 'MGA',
    ]);

    return response()->json($req, 201);
  }

  public function saveAnswers(Request $request, int $id)
  {
    $reqModel = PredictionRequest::where('id', $id)
      ->where('user_id', $request->user()->id)
      ->firstOrFail();

    $data = $request->validate([
      'answers' => ['required','array'],
      'answers.*.question_id' => ['required','integer'],
      'answers.*.value' => ['required'],
    ]);

    foreach ($data['answers'] as $a) {
      PredictionAnswer::updateOrCreate(
        ['prediction_request_id'=>$reqModel->id,'question_id'=>$a['question_id']],
        ['value'=>is_array($a['value']) ? json_encode($a['value']) : (string)$a['value']]
      );
    }

    return response()->json(['ok'=>true]);
  }

  public function checkout(Request $request, int $id)
  {
    $reqModel = PredictionRequest::where('id', $id)
      ->where('user_id', $request->user()->id)
      ->firstOrFail();

    if ($reqModel->status !== 'draft') {
      return response()->json(['message'=>'Invalid state'], 409);
    }

    $reqModel->update(['status'=>'pending_payment']);

    // Le frontend redirigera vers /fakepay?request_id=...
    return response()->json([
      'request_id' => $reqModel->id,
      'amount' => $reqModel->total_amount,
      'currency' => $reqModel->currency
    ]);
  }

  public function run(Request $request, PredictionEngine $engine, int $id)
  {
    $reqModel = PredictionRequest::where('id', $id)
      ->where('user_id', $request->user()->id)
      ->with(['answers.question','payment','result'])
      ->firstOrFail();

    if (!$reqModel->payment || $reqModel->payment->status !== 'succeeded') {
      return response()->json(['message'=>'Payment required'], 402);
    }
    if ($reqModel->result) {
      return response()->json(['message'=>'Already generated'], 409);
    }

    $reqModel->update(['status'=>'processing']);

    $gen = $engine->generate($reqModel);

    PredictionResult::create([
      'prediction_request_id' => $reqModel->id,
      'result_json' => $gen['result'],
      'score' => $gen['score'],
      'confidence_label' => $gen['confidence_label'],
      'generated_at' => now(),
    ]);

    $reqModel->update(['status'=>'done']);

    return response()->json(['ok'=>true]);
  }

  public function get(Request $request, int $id)
  {
    $reqModel = PredictionRequest::where('id', $id)
      ->where('user_id', $request->user()->id)
      ->with(['answers.question','result','payment'])
      ->firstOrFail();

    return response()->json($reqModel);
  }

  public function history(Request $request)
  {
    return PredictionRequest::where('user_id', $request->user()->id)
      ->latest('id')
      ->with(['result','payment'])
      ->paginate(20);
  }
}
