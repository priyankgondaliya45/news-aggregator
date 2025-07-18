<?php

use Illuminate\Support\Facades\Route;

Route::middleware('throttle:news-api')->group(function () {
    Route::get('/articles', [\App\Http\Controllers\ArticleController::class, 'index']);
    Route::get('/authors', [\App\Http\Controllers\AuthorController::class, 'index']);
    Route::get('/news-categories', [\App\Http\Controllers\NewsCategoryController::class, 'index']);
    Route::get('/news-providers', [\App\Http\Controllers\NewsProviderController::class, 'index']);
    Route::get('/news-sources', [\App\Http\Controllers\NewsSourcesController::class, 'index']);
});
?>