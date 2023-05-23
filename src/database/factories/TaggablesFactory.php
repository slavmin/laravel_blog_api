<?php

namespace Database\Factories;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TaggablesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tag_id' => Tag::query()->inRandomOrder()->limit(1)->pluck('uuid')[0],
            'taggable_id' => Post::query()->inRandomOrder()->limit(1)->pluck('uuid')[0],
            'taggable_type' => Post::class,
        ];
    }
}
