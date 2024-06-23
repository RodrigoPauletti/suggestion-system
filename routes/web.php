<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuggestionController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware('auth')->group(function () {
    Route::get('/new-suggestion', function () {
        return view('new-suggestion');
    })->name('suggestion.create');
    Route::get('/update-suggestion/{suggestion}', [SuggestionController::class, 'show'])->name('suggestion.edit-status');
    Route::put('/update-suggestion/{suggestion}', [SuggestionController::class, 'update'])->name('suggestion.change-status');
});

require __DIR__.'/auth.php';
