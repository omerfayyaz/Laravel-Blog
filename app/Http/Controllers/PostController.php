<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $posts = Post::orderBy('id', 'DESC')
            ->when($request->search, function ($query) use ($request) {
                $query->where('title', "like", "%" . $request->search . "%")
                    ->orWhere('body', "like", "%" . $request->search . "%");
            })
            ->paginate(10);

        return view('posts.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostStoreRequest $request)
    {
        //Validation
        //Used PostStoreRequest class for validation.

        DB::beginTransaction();
        try {

            $post = Post::create([
                'title' => $request->title,
                'body' => $request->body,
                'user_id' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('posts.index')->with('success', 'The new post created successfully.');
        } catch (\Exception  $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'The new post creation was unsuccessful. Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        if ($post->user_id != auth()->id()) {
            abort(403, 'You are not allowed to edit this post.');
        }

        return view('posts.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        //Validation
        //Used PostUpdateRequest class for validation.

        if ($post->user_id != auth()->id()) {
            abort(403, 'You are not allowed to edit this post.');
        }

        DB::beginTransaction();
        try {

            $post->title = $request->title;
            $post->body = $request->body;
            $post->save();

            DB::commit();
            return redirect()->route('posts.index')->with('success', 'The post updated successfully.');
        } catch (\Exception  $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'The post updation was unsuccessful. Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if ($post->user_id != auth()->id()) {
            abort(403, 'You are not allowed to delete this post.');
        }

        DB::beginTransaction();
        try {

            $post->delete();

            DB::commit();
            return redirect()->route('posts.index')->with('success', 'The post deleted successfully.');
        } catch (\Exception  $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'The post deletion was unsuccessful. Error: ' . $e->getMessage());
        }
    }
}
