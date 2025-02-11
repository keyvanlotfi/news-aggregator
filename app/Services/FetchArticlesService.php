<?php

namespace App\Services;

use App\Repositories\ArticleRepositoryInterface;
use App\Services\Strategies\SourceRequestStrategy;

class FetchArticlesService
{
    protected $strategy;
    protected $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function setStrategy(SourceRequestStrategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function fetchAndStoreArticles(): void
    {
        $articles = $this->strategy->fetchArticles();

        foreach ($articles as $article) {
            $this->articleRepository->store($article);
        }
    }
}
