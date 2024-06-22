<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use App\Enums\SuggestionStatus;

class Suggestion extends Model
{
    use HasFactory;

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
            $model->id = Str::uuid();
            $model->author_id = auth()->user()->id;
            $model->status = SuggestionStatus::PENDING;
        });
    }

}
