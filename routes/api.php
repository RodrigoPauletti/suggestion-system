<?php

use App\Http\Controllers\SuggestionController as Suggestion;

Route::middleware('auth')->group(function () {
    Route::apiResources([
        'suggestions' => Suggestion::class
    ]);
});
