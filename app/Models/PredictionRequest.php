<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PredictionRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'prediction_category_id',
        'questionnaire_id',
        'status',
        'total_amount',
        'currency',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(PredictionCategory::class, 'prediction_category_id');
    }

    public function questionnaire(): BelongsTo
    {
        return $this->belongsTo(Questionnaire::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(PredictionAnswer::class);
    }

    public function result(): HasOne
    {
        return $this->hasOne(PredictionResult::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
