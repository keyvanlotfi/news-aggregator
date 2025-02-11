<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    protected $model = Article::class;


    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'description' => fake()->sentence(),
            'url' => fake()->url(),
            'author' => fake()->name(),
            'source' => fake()->company(),
            'category' => fake()->word(),
        ];
    }
}
