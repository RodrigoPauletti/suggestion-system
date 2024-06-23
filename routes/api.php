<?php

use App\Http\Controllers\SuggestionController as Suggestion;

Route::middleware('auth')->group(function () {
    Route::put('suggestions/vote/{suggestion}', [Suggestion::class, 'vote'])->name('vote');
    Route::apiResources([
        'suggestions' => Suggestion::class
    ]);
});
