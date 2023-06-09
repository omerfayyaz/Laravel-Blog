<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentStoreRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{

    public function store(CommentStoreRequest $request, Post $post)
    {
        //Validation
        //Used CommentStoreRequest class for validation.

        if (auth()->user())
        {
            $request['user_name'] = auth()->user()->name;
        }

        DB::beginTransaction();
        try {

            $comment = Comment::create([
                'post_id' => $post->id,
                'user_name' => $request->user_name,
                'body' => $request->body,
            ]);

            DB::commit();
            return redirect()->route('posts.show', $post->id)->with('success', 'The new comment submitted successfully.');
        } catch (\Exception  $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'The new comment submission was unsuccessful. Error: ' . $e->getMessage());
        }
    }
}
