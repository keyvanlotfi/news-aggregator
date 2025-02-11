<?php

use App\Models\Article;
use App\Services\FetchArticlesService;
use App\Services\Strategies\NewsApiStrategy;
use App\Services\Strategies\NewYorkTimesStrategy;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;


Route::get('/', function() {

});
