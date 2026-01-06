<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Questionnaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'prediction_category_id',
        'version',
        'title',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'version' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(PredictionCategory::class, 'prediction_category_id');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function predictionRequests(): HasMany
    {
        return $this->hasMany(PredictionRequest::class);
    }
}
