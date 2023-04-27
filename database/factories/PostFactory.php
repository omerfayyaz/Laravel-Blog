<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph,
            'user_id' => function () {
                return User::factory()->create()->id;
            },
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Post $post) {
            $comments = Comment::factory()->count(5)->create([
                'post_id' => $post->id,
            ]);
            $post->comments()->saveMany($comments);
        });
    }
}
