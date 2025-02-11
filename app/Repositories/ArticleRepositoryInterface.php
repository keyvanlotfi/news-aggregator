<?php

namespace App\Repositories;

interface ArticleRepositoryInterface
{
    public function store(array $data): void;

    public function findById(int $id);

    public function getFilteredArticles(array $filters);
}
