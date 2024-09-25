<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

class CommentController extends Controller
{

    public function createComment(Request $request, Post $post)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $userId =  auth()->id();
    
        $validated_data = $request->validate([
            'body' => 'required|string'
        ]);

        $comment = $post->comments()->create([
            'body' => $validated_data['body'],
            'user_id' => $userId,
        ]);

        return response()->json($comment, 201);
    }

    public function updateComment(Request $request, Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated_data = $request->validate([
            'body' => 'required|string',
        ]);

        $comment->update([
            'body' => $validated_data['body'],
        ]);

        return response()->json(['message' => 'Comment updated successfully', 'comment' => $comment], 200);
    }

    public function deleteComment(Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully'], 200);
    }


}
