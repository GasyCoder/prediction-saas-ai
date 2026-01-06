<?php 

namespace App\Services;

class FakePaymentSigner
{
  public function sign(string $payload, string $secret): string
  {
    return hash_hmac('sha256', $payload, $secret);
  }

  public function verify(string $payload, string $secret, string $signature): bool
  {
    $expected = $this->sign($payload, $secret);
    return hash_equals($expected, $signature);
  }
}
