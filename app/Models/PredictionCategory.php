<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PredictionCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'description',
    ];

    public function questionnaires(): HasMany
    {
        return $this->hasMany(Questionnaire::class);
    }

    public function predictionRequests(): HasMany
    {
        return $this->hasMany(PredictionRequest::class);
    }
}
