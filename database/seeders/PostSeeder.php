<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        Author::all()->each(function (Author $author) {
            $posts = Post::factory()->count(rand(100, 500))->make();

            $author->posts()->saveMany($posts);
        });
    }
}
