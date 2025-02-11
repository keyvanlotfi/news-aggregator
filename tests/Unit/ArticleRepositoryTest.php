<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Repositories\ArticleRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class ArticleRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private ArticleRepository $articleRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->articleRepository = new ArticleRepository();
    }

    public function test_stores_an_article()
    {
        $data = [
            'title' => 'Test Article',
            'description' => 'This is a test article.',
            'url' => 'https://www.example.com/article/artile-slug',
            'author' => 'antony steve',
            'source' => 'new york times',
            'category' => 'education',
        ];

        $this->articleRepository->store($data);
        $this->assertDatabaseHas('articles', ['title' => 'Test Article']);
    }

    public function test_updates_existing_article()
    {
        Article::factory()->create([
            'title' => 'Test Article',
            'description' => 'Old description'
        ]);
        $data = [
            'title' => 'Test Article',
            'description' => 'Updated description.',
            'url' => 'https://www.example.com/article/artile-slug',
            'author' => 'antony steve',
            'source' => 'new york times',
            'category' => 'education',
        ];


        $this->articleRepository->store($data);
        $this->assertDatabaseHas('articles', ['description' => 'Updated description.']);
    }

    public function test_show_article_by_id()
    {
        $article = Article::factory()->create(['title' => 'test article']);
        $result = $this->articleRepository->findById($article->id);

        $this->assertNotNull($result);
        $this->assertEquals($article->id, $result->id);
    }
}
