<?php

namespace App\Repositories;


use App\Models\Article;
use App\Services\ArticleFilterService;

class ArticleRepository implements ArticleRepositoryInterface
{
    public function store(array $data): void
    {
        Article::updateOrCreate(
            ['title' => $data['title']],
            [
                'title'       => $data['title'],
                'description' => $data['description'],
                'url'         => $data['url'],
                'author'      => $data['author'],
                'source'      => $data['source'],
                'category'    => $data['category']
            ]
        );
    }

    public function findById(int $id)
    {
        return Article::findOrFail($id);
    }

    public function getFilteredArticles(array $filters)
    {
        $query = Article::query();

        // simulating user preferences because we have not implemented login system
//        $userPreferences = [
//            'preferred_categories' => ['rerum', 'education'],
//        ];

        $query = app(ArticleFilterService::class)->applyFilters($query, $filters);

        // add user preferences filters (if they exist) to the query
//        $query->when($userPreferences['preferred_categories'] ?? null, fn($q, $categories) => $q->whereIn('category', $categories));

        return $query->paginate(10);
    }
}
