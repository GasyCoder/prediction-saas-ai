<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PredictionResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'prediction_request_id',
        'result_json',
        'score',
        'confidence_label',
        'generated_at',
    ];

    protected $casts = [
        'result_json' => 'array',
        'score' => 'integer',
        'generated_at' => 'datetime',
    ];

    public function request(): BelongsTo
    {
        return $this->belongsTo(PredictionRequest::class, 'prediction_request_id');
    }
}
