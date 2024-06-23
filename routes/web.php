<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SuggestionController as Suggestion;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('suggestions', [Suggestion::class, 'index'])->name('suggestions.index');

Route::middleware('auth')->group(function () {
    Route::get('/new-suggestion', function () {
        return view('new-suggestion');
    })->name('suggestion.create');
    Route::get('/update-suggestion/{suggestion}', [
        Suggestion::class, 'show'
    ])->name('suggestion.edit-status');
    Route::put('/update-suggestion/{suggestion}', [
        Suggestion::class, 'update'
    ])->name('suggestion.change-status');
    Route::controller(Suggestion::class)->prefix('/suggestions')->name('suggestions.')->group(function() {
        Route::post('', 'store')->name('store');
        Route::put('vote/{suggestion}', 'vote')->name('vote');
    });
});

require __DIR__.'/auth.php';
