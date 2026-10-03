<?php

namespace Database\Factories;

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<News>
 */
class NewsFactory extends Factory
{
    protected $model = News::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => NewsCategory::factory(),
            'author_id' => User::factory(),
            'title' => fake()->sentence(),
            'slug' => fake()->unique()->slug(),
            'excerpt' => fake()->paragraph(),
            'content' => fake()->paragraphs(3, true),
            'thumbnail' => null,
            'status' => 'draft',
            'published_at' => null,
        ];
    }
}
