<?php

use App\Http\Controllers\API\ArticleController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'],function () {
    // to get the articles by supporting the filters
    Route::get('/articles', [ArticleController::class, 'index']);

    // to show specific article
    Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show');
});
