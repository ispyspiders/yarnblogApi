<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * GET all posts
     */
    public function index()
    {
        // Returnera alla inlägg
        return Post::all();
    }

    /**
     * POST new post
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * GET post by id
     */
    public function show(string $id)
    {
        // Kontrollera om valt id finns, returnera i så fall inlägg med valt id
        $post = Post::find($id);
        if ($post != null) return $post;
        else {
            return response()->json([
                'error' => 'Post not found',
                'message' => 'No post with the chosen id was found'
            ], 404);
        }
    }

    /**
     * Update the specified post. (PUT)
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * DELETE the specified post.
     */
    public function destroy(string $id)
    {
        //
    }
}
