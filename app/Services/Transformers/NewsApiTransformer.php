<?php

namespace App\Services\Transformers;

class NewsApiTransformer implements ArticleTransformerInterface
{

    public function transform(array $data): array
    {
        return [
            'title'       => $data['title'] ?? '',
            'description' => $data['description'] ?? '',
            'url'         => $data['url'] ?? '',
            'author'      => $data['author'] ?? 'Unknown',
            'source'      => $data['source']['name'] ?? '',
            'category'    => 'news api' ?? '',
        ];
    }
}
