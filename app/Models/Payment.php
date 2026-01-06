<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'prediction_request_id',
        'provider',
        'status',
        'tx_ref',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function request(): BelongsTo
    {
        return $this->belongsTo(PredictionRequest::class, 'prediction_request_id');
    }
}
