<?php

namespace App\Services\Transformers;

class TheGuardianTransformer implements ArticleTransformerInterface
{

    public function transform(array $data): array
    {
        return [
            'title'       => $data['webTitle'] ?? '',
            'description' => $data['webTitle'] ?? '',
            'url'         => $data['webUrl'] ?? '',
            'author'      => 'the guardian',
            'source'      => 'the guardian',
            'category'    => $data['sectionName'] ?? ''
        ];
    }
}
