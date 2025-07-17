<?php

use Illuminate\Support\Facades\Route;

Route::get('/articles', [\App\Http\Controllers\ArticleController::class, 'index']);
Route::get('/authors', [\App\Http\Controllers\AuthorController::class, 'index']);
Route::get('/news-providers', [\App\Http\Controllers\NewsProviderController::class, 'index']);

?>