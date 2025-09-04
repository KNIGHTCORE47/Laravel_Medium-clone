<?php

namespace Database\Factories;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;

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
        $title = fake()->sentence();

        // $user_id = User::inRandomOrder()->value('id');   // Get a random user ID

        return [
            'image' => fake()->imageUrl(),
            'title' => $title,
            'slug' => \Illuminate\Support\Str::slug($title),
            'content' => fake()->paragraph(5, true),
            'user_id' => 2,
            'category_id' => Category::inRandomOrder()->value('id'),
            'published_at' => fake()->optional()->dateTime(),
        ];
    }
}
