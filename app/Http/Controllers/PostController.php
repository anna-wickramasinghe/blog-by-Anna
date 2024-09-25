<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Policies\PostPolicy\update;

class PostController extends Controller
{
    
    // creates a new post
    public function createPost(Request $request)
    {
        $validated_data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'status' => 'required|in:published,draft',
        ]);

        $post = auth()->user()->posts()->create($validated_data);

        return response()->json($post, 201);
    }

    public function editPost(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'status' => 'required|in:published,draft',
        ]);

        $post->update($validated);

        return response()->json($post, 200);
    }

    public function deletePost(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return response()->json(['message' => 'Post deleted successfully'], 200);
    }


    public function showAllPosts(Request $request)
    {
        // filtering on the status
        $query = Post::where('status', 'published')->orderBy('created_at', 'desc');
    
        // Apply search
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
    
        $posts = $query->with(['user', 'comments.user'])->paginate(10);
    
        return response()->json($posts);
    }

    public function showAllDraftsandPublished(Request $request)
    {
        // filtering on the status if query parameter for status is available
        $query = Post::query()
        ->when($request->has('status'), function ($q) use ($request) {
            $q->where('status', $request->status);
        }, function ($q) {
            $q->where('status', 'published');
        });

        // Apply search 
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $posts = $query->with(['user', 'comments.user'])->orderBy('created_at', 'desc')->paginate(10);

        return response()->json($posts);
    }
}
