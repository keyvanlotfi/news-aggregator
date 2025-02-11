<?php

namespace App\Services\Transformers;

class NewYorkTimesTransformer implements ArticleTransformerInterface
{

    public function transform(array $data): array
    {
        return [
            'title'       => $data['title'] ?? '',
            'description' => $data['abstract'] ?? '',
            'url'         => $data['url'] ?? '',
            'author'      => $data['byline'] ?? 'Unknown',
            'source'      => $data['url'] ?? '',
            'category'    => $data['section'] ?? ''
        ];
    }
}
