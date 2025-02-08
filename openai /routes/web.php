<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Openaiservice;


Route::get('/history', function () {
    return view("history", compact("insights"));
});

Route::get('/summarizelogs', function () {
    return view('summarizelogs');
});

Route::get('/', function () {
    return view('welcome');
});


Route::get('openai', [OpenAiService::class, 'getInsight'])->name('openai.sendRequest');
Route::post('openai', [OpenAiService::class, 'storetInsight'])->name('openai.store');
