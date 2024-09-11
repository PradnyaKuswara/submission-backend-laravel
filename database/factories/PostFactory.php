<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'post_category_id' => $this->faker->numberBetween(1, 10),
            'user_id' => $this->faker->numberBetween(1, 2),
            'slug' => $this->faker->slug,
            'meta_description' => $this->faker->sentence,
            'meta_keyword' => $this->faker->sentence,
            'is_active' => 1,

        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (\App\Models\Post $post) {
            $url = 'https://picsum.photos/200';
            $post
                ->addMediaFromUrl($url)
                ->toMediaCollection('posts' . '-' . $post->uuid);
        });
    }
}
