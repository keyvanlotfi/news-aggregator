<?php

namespace App\Services\Strategies;

interface SourceRequestStrategy
{
    public function fetchArticles(): array;
}
