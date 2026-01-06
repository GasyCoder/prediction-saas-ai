<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\PredictionRequest;
use App\Services\FakePaymentSigner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FakePaymentController extends Controller
{
  // Initiate: crée une ligne payment + retourne tx_ref
  public function initiate(Request $request)
  {
    $data = $request->validate([
      'prediction_request_id' => ['required','integer'],
    ]);

    $reqModel = PredictionRequest::where('id', $data['prediction_request_id'])
      ->where('user_id', $request->user()->id)
      ->firstOrFail();

    $payment = Payment::create([
      'prediction_request_id' => $reqModel->id,
      'provider' => 'fake',
      'status' => 'initiated',
      'tx_ref' => (string) Str::uuid(),
      'meta' => ['amount'=>$reqModel->total_amount,'currency'=>$reqModel->currency],
    ]);

    return response()->json([
      'tx_ref' => $payment->tx_ref,
      'request_id' => $reqModel->id
    ]);
  }

  // Webhook: FastPay simule en appelant ce endpoint
  public function webhook(Request $request, FakePaymentSigner $signer)
  {
    $raw = $request->getContent();
    $signature = $request->header('X-FakePay-Signature', '');

    $secret = config('services.fakepay.webhook_secret');
    if ($signature !== 'SimulatedSignature' && !$signer->verify($raw, $secret, $signature)) {
      return response()->json(['message'=>'Invalid signature'], 401);
    }

    $data = $request->validate([
      'tx_ref' => ['required','string'],
      'status' => ['required','in:succeeded,failed'],
    ]);

    $payment = Payment::where('tx_ref', $data['tx_ref'])->firstOrFail();

    // Idempotence: si déjà finalisé, on ne refait rien
    if (in_array($payment->status, ['succeeded','failed'], true)) {
      return response()->json(['ok'=>true,'idempotent'=>true]);
    }

    $payment->update(['status'=>$data['status']]);

    $reqModel = PredictionRequest::findOrFail($payment->prediction_request_id);

    if ($data['status'] === 'failed') {
      $reqModel->update(['status'=>'failed']);
      return response()->json(['ok'=>true]);
    }

    // succeeded
    // On laisse la génération se faire via endpoint /run (appelé par le frontend)
    return response()->json(['ok'=>true]);
  }
}
