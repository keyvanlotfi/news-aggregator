<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;


class ArticleFilterService
{
    public function applyFilters(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['title'] ?? null, fn ($q, $title) => $q->where('title', 'like', '%' . $title . '%'))
            ->when($filters['author'] ?? null, fn ($q, $author) => $q->where('author', 'like', '%' . $author . '%'))
            ->when($filters['source'] ?? null, fn ($q, $source) => $q->where('source', 'like', '%' . $source . '%'))
            ->when($filters['category'] ?? null, fn ($q, $category) => $q->where('category', $category))
            ->when($filters['date'] ?? null, fn ($q, $date) => $q->whereDate('created_at', $date));
    }
}
