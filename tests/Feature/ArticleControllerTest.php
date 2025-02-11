<?php

namespace Tests\Feature;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_articles_with_filters()
    {
        Article::factory()->create(['title' => 'Laravel Article', 'author' => 'John carl']);
        Article::factory()->create(['title' => 'Vue Article', 'author' => 'steve queen']);

        // Act: Make a request with a filter
        $response = $this->getJson('/api/v1/articles?title=Laravel');

        // Assert: Check if only the filtered article is returned
        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonFragment(['title' => 'Laravel Article']);
    }

    public function test_returns_404_if_article_not_found()
    {
        $response = $this->getJson('/api/v1/articles/999');

        $response->assertStatus(404);
    }

    public function test_can_get_paginated_articles_with_filters()
    {
        Article::factory()->create(['title' => 'Laravel Guide']);
        Article::factory()->create(['title' => 'Vue Guide']);
        Article::factory()->create(['title' => 'React Guide']);


        $response = $this->getJson('/api/v1/articles?title=Laravel Guide');

        // Assert: Check if the response is paginated and contains filtered data
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'description',
                        'url',
                        'author',
                        'source',
                        'category',
                        'created_at',
                        'updated_at'
                    ] // Structure of each article
                ],
                'pagination' => [
                    'total',
                    'per_page',
                    'current_page',
                    'last_page',
                ]
            ])
            ->assertJsonFragment(['title' => 'Laravel Guide']);


        $this->assertCount(1, $response->json('data'));
    }
}
