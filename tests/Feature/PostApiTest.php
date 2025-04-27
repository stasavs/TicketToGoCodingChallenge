<?php

use App\Models\Post;
use App\Models\Author;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

uses(RefreshDatabase::class);

it('can list posts with authors and comments', function () {
    // Arrange: create fake data
    $author = Author::factory()->create();
    $post = Post::factory()->create(['author_id' => $author->id]);
    Comment::factory()->count(3)->create(['post_id' => $post->id]);

    // Act: call the API
    $response = $this->getJson('/api/posts');

    // Assert: check response
    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'title',
                    'author',
                    'comments' => [
                        '*' => [
                            'name',
                            'text'
                        ]
                    ]
                ]
            ],
            'meta',
            'links'
        ]);
});

it('can paginate posts correctly', function () {
    // Arrange: make 50 posts
    $author =  Author::factory()->create();
    Post::factory()->count(50)->create([
        'author_id' => $author->id, // Connect each post to existing author
    ]);

    // Act: fetch 15 posts per page
    $response = $this->getJson('/api/posts?per_page=15');

    // Assert
    $response->assertOk()
        ->assertJsonPath('meta.per_page', 15)
        ->assertJsonPath('meta.current_page', 1);
});

it('can position pagination on correct page', function () {

    // Act: fetch 10 posts per page
    $response = $this->getJson('/api/posts?per_page=10&page=2');

    // Assert
    $response->assertOk()
        ->assertJsonPath('meta.per_page', 10)
        ->assertJsonPath('meta.current_page', 2);
});

it('can validate max per page is 100', function () {

    $response = $this->getJson('/api/posts?per_page=1000');

    // Assert
    $response->assertStatus(422)->assertJsonValidationErrorFor('per_page');
});

it('can filter posts by author_id', function () {
    // Arrange
    $authors = Author::factory()->count(2)->create();

    // Create posts for each author
    $authorOnePosts = Post::factory()->count(5)->create([
        'author_id' => $authors[0]->id,
    ]);

    $authorTwoPosts = Post::factory()->count(5)->create([
        'author_id' => $authors[1]->id,
    ]);

    // Act: Fetch posts filtered by first author's ID
    $response = $this->getJson('/api/posts?author_id=' . $authors[0]->id);

    // Assert
    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'title',
                    'author',
                    'comments',
                ]
            ],
            'meta',
            'links'
        ])
        ->assertJsonCount(5, 'data');
    $responseData = $response->json('data');

    foreach ($responseData as $post) {
        expect($post['author'])->toBe($authors[0]->name);
    }
});

it('can validate author id', function () {

    $response = $this->getJson('/api/posts?author_id=stasa');

    // Assert
    $response->assertStatus(422)->assertJsonValidationErrorFor('author_id');
});

it('can filter posts by title', function () {
    // Arrange
    $author = Author::factory()->create();

    $matchingPost = Post::factory()->create([
        'author_id' => $author->id,
        'title' => 'TicketGo Coding Challenge',
    ]);

    $nonMatchingPost = Post::factory()->create([
        'author_id' => $author->id,
        'title' => 'List blogposts with their authors and comments',
    ]);

    // Act: Search posts containing "TicketGo"
    $response = $this->getJson('/api/posts?title=TicketGo');

    // Assert
    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'title',
                    'author',
                    'comments'
                ]
            ],
            'meta',
            'links'
        ])
        ->assertJsonCount(1, 'data'); // Only one post should match

    $responseData = $response->json('data');

    foreach ($responseData as $post) {
        expect($post['title'])->toContain('TicketGo');
    }
});

it('validates that title cannot exceed 255 characters', function () {
    $tooLongTitle = str_repeat('A', 256);

    $response = $this->getJson('/api/posts?title=' . $tooLongTitle);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['title']);
});

it('validates that page must be an integer', function () {
    $response = $this->getJson('/api/posts?page=not-an-integer');

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['page']);
});

