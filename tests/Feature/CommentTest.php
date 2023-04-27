<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testCommentStoreWithValidData()
    {
        $this->actingAs($user = User::factory()->create());
        $post = Post::factory()->create(['user_id' => $user]);

        $data = [
            'body' => $this->faker->paragraph,
        ];

        $response = $this->post(route('comments.store', $post->id), $data);
        $response->assertStatus(302);
        $response->assertRedirect(route('posts.show', $post->id));
        $response->assertSessionHas('success', 'The new comment submitted successfully.');
        $this->assertDatabaseHas('comments', $data);
    }

    public function testCommentStoreWithInvalidData()
    {
        $this->actingAs($user = User::factory()->create());
        $post = Post::factory()->create(['user_id' => $user]);

        $data = [
            'body' => '',
        ];

        $response = $this->post(route('comments.store', $post->id), $data);
        $response->assertStatus(302);
        $response->assertSessionHas('errors');
        $this->assertDatabaseMissing('comments', $data);
    }
}
