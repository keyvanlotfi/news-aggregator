<?php

namespace App\Services\Strategies;

use App\Services\Transformers\NewsApiTransformer;
use Illuminate\Support\Facades\Http;

class NewsApiStrategy implements SourceRequestStrategy
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'url' => 'https://newsapi.org/v2/everything',
            'api-key' => '7b22f3a547bb4b08ace4f33981ffef93', // insert your own api key from (news api)
        ];
    }



    public function fetchArticles(): array
    {
        $response = Http::get($this->config['url'], [
            'q' => 'Apple',
            'from' => now()->subDays(7)->toDateString(),
            'sortBy' => 'popularity',
            'apiKey' => $this->config['api-key'],
        ]);



        if ($response->successful()) {
            $data = $response->json()['articles'];
            $transformer = new NewsApiTransformer();
            return array_map(fn($article) => $transformer->transform($article), $data);
        }


        return [];
    }
}
