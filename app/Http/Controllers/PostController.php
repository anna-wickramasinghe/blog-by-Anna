<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
