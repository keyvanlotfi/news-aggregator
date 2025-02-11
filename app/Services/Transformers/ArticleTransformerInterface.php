<?php

namespace App\Services\Transformers;

interface ArticleTransformerInterface
{
    public function transform(array $data): array;
}
