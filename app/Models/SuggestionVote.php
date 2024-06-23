<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SuggestionVote extends Model
{
    use HasFactory;

    // Model configs to set the PK as UUID
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'suggestion_id',
        'user_id',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::creating(function (SuggestionVote $model) {
            $model->id = Str::uuid(); // Automatically generate an UUID
            $model->user_id = auth()->user()->id; // Set the logged user a voter of the suggestion
        });
    }

}
