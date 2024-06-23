<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use App\Enums\SuggestionStatus;

class Suggestion extends Model
{
    use HasFactory;

    // Model configs to set the PK as UUID
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'title',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => SuggestionStatus::class,
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::creating(function (Suggestion $model) {
            $model->id = Str::uuid(); // Automatically generate an UUID
            $model->author_id = auth()->user()->id; // Link the logged user to the author of the suggestion
            $model->status = SuggestionStatus::PENDING; // Initial suggestion status = 'pending'
        });
    }

}
