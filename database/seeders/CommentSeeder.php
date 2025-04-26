<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::all()->each(function (Post $post) {
            $comments = Comment::factory()->count(rand(1, 50))->make();
            $post->comments()->saveMany($comments);
        });

    }
}
