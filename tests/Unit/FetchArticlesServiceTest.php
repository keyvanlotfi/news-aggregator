<?php

namespace Tests\Unit;

use App\Repositories\ArticleRepositoryInterface;
use App\Services\FetchArticlesService;
use App\Services\Strategies\SourceRequestStrategy;
use Mockery;
use Tests\TestCase;


class FetchArticlesServiceTest extends TestCase
{
    protected $fetchArticlesService, $articleRepositoryMock, $strategyMock;


    protected function setUp(): void
    {
        parent::setUp();

        $this->articleRepositoryMock = Mockery::mock(ArticleRepositoryInterface::class);
        $this->strategyMock = Mockery::mock(SourceRequestStrategy::class);

        $this->fetchArticlesService = new FetchArticlesService($this->articleRepositoryMock);
    }

    public function test_fetchAndStoreArticles_calls_store_for_each_article()
    {
        $articles = [
            ['title' => 'Article 1', 'author' => 'Author 1'],
            ['title' => 'Article 2', 'author' => 'Author 2'],
        ];

        // Mock the strategy to return these articles
        $this->strategyMock
            ->shouldReceive('fetchArticles')
            ->once()
            ->andReturn($articles);

        // Set the strategy in the service
        $this->fetchArticlesService->setStrategy($this->strategyMock);

        // Expect the repository's store method to be called twice with the correct data
        $this->articleRepositoryMock
            ->shouldReceive('store')
            ->twice()
            ->with(Mockery::any());

        $this->fetchArticlesService->fetchAndStoreArticles();
    }

    public function test_fetchAndStoreArticles_does_nothing_when_no_articles_returned()
    {
        // Mock the strategy to return an empty array
        $this->strategyMock
            ->shouldReceive('fetchArticles')
            ->once()
            ->andReturn([]);

        $this->fetchArticlesService->setStrategy($this->strategyMock);

        // Expect the store method to never be called
        $this->articleRepositoryMock
            ->shouldNotReceive('store');

        $this->fetchArticlesService->fetchAndStoreArticles();
    }
}
