<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     * Returnera alla kommentarer för inlägg med angivet id
     */
    public function index(string $id)
    {
        // Läs in inlägg
        $post = Post::find($id);
        // Om inlägg inte finns - 404
        if ($post == null) {
            return response()->json([
                'error' => 'Post not found',
                'message' => 'No post with the chosen id was found'
            ], 404);
        }
        // läs in kommentarer för inlägg och returnera - 200
        $comments = $post->comments;
        return response()->json($comments, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $id)
    {
        // Läs in inlägg
        $post = Post::find($id);
        // Om inlägg inte finns - 404
        if ($post == null) {
            return response()->json([
                'error' => 'Post not found',
                'message' => 'No post with the chosen id was found'
            ], 404);
        }

        // Validera ingående data
        $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        // Läs in autentiserad användare
        $user = $request->user();

        // Skapa kommentar
        return Comment::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'comment' => $request->comment
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        // Läs in kommentar
        $comment = Comment::find($id);

        // Kommentar hittas ej
        if ($comment == null) {
            return response()->json([
                'error' => 'Comment not found',
                'message' => 'No comment with the chosen id was found'
            ], 404);
        }

        //Hämta inlägg
        $post = Post::find($comment->post_id);

        // Hämta autentiserad användare
        $user = $request->user();

        // Om autentiserad användare inte är samma som kommentarens författare 
        // ELLER om autentiserad användare inte är samma som inläggets författare - Unauthorized 403
        if (!($user->id === $post->user_id || $user->id === $comment->user_id)) {
            return response()->json([
                'error' => 'Unauthorized user',
                'messsage' => 'You do not have sufficent permissions to perform this action'
            ], 403);
        }

        // Radera kommentar
        $comment->delete();
        return response()->json([
            'message' => 'Kommentar raderad'
        ]);
    }
}
