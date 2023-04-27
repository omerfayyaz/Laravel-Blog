<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testPostIndex()
    {
        Post::factory()->count(15)->create();

        $response = $this->get(route('posts.index'));
        $response->assertStatus(200);
        $response->assertViewIs('posts.index');
        $response->assertViewHas('posts');
        $response->assertSee(Post::orderBy('id', 'DESC')->paginate(10)->render());
    }

    public function testPostCreate()
    {
        $this->actingAs(User::factory()->create());

        $response = $this->get(route('posts.create'));
        $response->assertStatus(200);
        $response->assertViewIs('posts.create');
    }

    public function testPostStoreWithValidData()
    {
        $this->actingAs(User::factory()->create());

        $data = [
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph,
        ];

        $response = $this->post(route('posts.store'), $data);
        $response->assertStatus(302);
        $response->assertRedirect(route('posts.index'));
        $response->assertSessionHas('success', 'The new post created successfully.');
        $this->assertDatabaseHas('posts', $data);
    }

    public function testPostStoreWithInvalidData()
    {
        $this->actingAs(User::factory()->create());

        $data = [
            'title' => '',
            'body' => '',
        ];

        $response = $this->post(route('posts.store'), $data);
        $response->assertStatus(302);
        $response->assertSessionHas('errors');
        $this->assertDatabaseMissing('posts', $data);
    }

    public function testPostShowPostWithComments()
    {
        $post = Post::factory()->create();

        $response = $this->get(route('posts.show', $post->id));
        $response->assertStatus(200);
        $response->assertViewIs('posts.show');
        $response->assertViewHas('post');
        $response->assertSee($post->title);
        $response->assertSee($post->body);
        $response->assertSee($post->comments[0]->body);
        $response->assertSee($post->comments[1]->body);
        $response->assertSee($post->comments[2]->body);
        $response->assertSee($post->comments[3]->body);
        $response->assertSee($post->comments[4]->body);
    }

    public function testPostEditWithAuthorizedUser()
    {
        $post = Post::factory()->create(['user_id' => $user = User::factory()->create()]);

        $this->actingAs($user);

        $response = $this->get(route('posts.edit', $post->id));
        $response->assertStatus(200);
        $response->assertViewIs('posts.edit');
        $response->assertViewHas('post');
    }


    public function testPostEditWithUnauthorizedUser()
    {
        $post = Post::factory()->create(['user_id' => User::factory()->create()]);

        $this->actingAs(User::factory()->create());

        $response = $this->get(route('posts.edit', $post->id));
        $response->assertStatus(403);
    }

    public function testPostUpdateWithAuthorizedUserAndValidData()
    {
        $post = Post::factory()->create(['user_id' => $user = User::factory()->create()]);

        $this->actingAs($user);

        $data = [
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph,
        ];

        $response = $this->put(route('posts.update', $post->id), $data);

        $response->assertStatus(302);
        $response->assertRedirect(route('posts.index'));
        $response->assertSessionHas('success', 'The post updated successfully.');
        $this->assertDatabaseHas('posts', $data);
    }

    public function testPostUpdateWithUnauthorizedUser()
    {
        $post = Post::factory()->create(['user_id' => User::factory()->create()]);

        $this->actingAs(User::factory()->create());

        $data = [
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph,
        ];

        $response = $this->put(route('posts.update', $post->id), $data);
        $response->assertStatus(403);
        $this->assertDatabaseMissing('posts', $data);
    }

    public function testPostUpdateWithAuthorizedUserAndInvalidData()
    {
        $post = Post::factory()->create(['user_id' => $user = User::factory()->create()]);

        $this->actingAs($user);

        $data = [
            'title' => '',
            'body' => '',
        ];

        $response = $this->put(route('posts.update', $post->id), $data);
        $response->assertStatus(302);
        $response->assertSessionHas('errors');
        $this->assertDatabaseMissing('posts', $data);
    }

    public function testPostDestroyWithAuthorizedUser()
    {
        $post = Post::factory()->create(['user_id' => $user = User::factory()->create()]);

        $this->actingAs($user);

        $response = $this->delete(route('posts.destroy', $post->id));
        $response->assertStatus(302);
        $response->assertRedirect(route('posts.index'));
        $response->assertSessionHas('success', 'The post deleted successfully.');
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    public function testPostDestroyWithUnauthorizedUser()
    {
        $post = Post::factory()->create(['user_id' => User::factory()->create()]);

        $this->actingAs(User::factory()->create());

        $response = $this->delete(route('posts.destroy', $post->id));
        $response->assertStatus(403);
        $this->assertDatabaseHas('posts', ['id' => $post->id]);
    }
}
