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
});

require __DIR__.'/auth.php';
