<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'username' => 'testuser',
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $categories = [
            'Technology',
            'Design',
            'Business',
            'Politics',
            'Sports',
            'Science',
            'Health',
            'Style',
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create([
                'name' => $category,
            ]);
        }

        // Post::factory(30)->create();
    }
}
