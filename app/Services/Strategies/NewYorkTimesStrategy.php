<?php

namespace App\Services\Strategies;

use App\Services\Transformers\NewYorkTimesTransformer;
use Illuminate\Support\Facades\Http;

class NewYorkTimesStrategy implements SourceRequestStrategy
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'url' => 'https://api.nytimes.com/svc/topstories/v2/home.json',
            'api-key' => 'FdgxoSJrGv6jNabTQBCTZV2Cnd6x81mp', // insert your own api key from (new york times)
        ];
    }



    public function fetchArticles(): array
    {
        $response = Http::get($this->config['url'], [
            'api-key' => $this->config['api-key'],
        ]);



        if ($response->successful()) {
            $data = $response->json()['results'];
            $transformer = new NewYorkTimesTransformer();
            return array_map(fn($article) => $transformer->transform($article), $data);
        }


        return [];
    }
}
