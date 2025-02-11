<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Services\ArticleFilterService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class ArticleFilterServiceTest extends TestCase
{
    use RefreshDatabase;
    private ArticleFilterService $filterService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->filterService = new ArticleFilterService();
    }


    public function test_filter_articles_by_title()
    {
        Article::factory()->create(['title' => 'Laravel News']);
        Article::factory()->create(['title' => 'PHP Tips']);
        Article::factory()->create(['title' => 'JavaScript Guide']);

        $query = Article::query();
        $filteredQuery = $this->filterService->applyFilters($query, ['title' => 'Laravel']);

        $this->assertCount(1, $filteredQuery->get());
        $this->assertEquals('Laravel News', $filteredQuery->first()->title);
    }


    public function test_filter_articles_by_author()
    {
        Article::factory()->create(['author' => 'John Doe']);
        Article::factory()->create(['author' => 'Jane Smith']);
        Article::factory()->create(['author' => 'John Smith']);

        $query = Article::query();
        $filteredQuery = $this->filterService->applyFilters($query, ['author' => 'John']);

        $this->assertCount(2, $filteredQuery->get());
    }


    public function test_returns_all_articles_when_no_filters_are_applied()
    {
        Article::factory()->count(5)->create();

        $query = Article::query();
        $filteredQuery = $this->filterService->applyFilters($query, []);

        $this->assertCount(5, $filteredQuery->get());
    }
}
