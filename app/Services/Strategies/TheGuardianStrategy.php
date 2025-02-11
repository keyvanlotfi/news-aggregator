<?php

namespace App\Services\Strategies;

use App\Services\Transformers\NewsApiTransformer;
use App\Services\Transformers\TheGuardianTransformer;
use Illuminate\Support\Facades\Http;

class TheGuardianStrategy implements SourceRequestStrategy
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'url' => 'https://content.guardianapis.com/search',
            'api-key' => '7e2b019f-c63a-49e7-8159-f30c9e3a4c68', // insert your own api key from (the guardian)
        ];
    }



    public function fetchArticles(): array
    {
        $response = Http::get($this->config['url'], [
            'page' => '1',
            'q' => 'debate',
            'api-key' => $this->config['api-key'],
        ]);



        if ($response->successful()) {
            $data = $response->json()['response']['results'];
            $transformer = new TheGuardianTransformer();
            return array_map(fn($article) => $transformer->transform($article), $data);
        }


        return [];
    }
}
