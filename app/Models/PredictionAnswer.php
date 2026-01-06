<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PredictionAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'prediction_request_id',
        'question_id',
        'value',
    ];

    public function request(): BelongsTo
    {
        return $this->belongsTo(PredictionRequest::class, 'prediction_request_id');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
