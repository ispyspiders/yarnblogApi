<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        // Validera ingående data
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' =>'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048'
        ]);

        // variabler för bild
        $file_path = null;
        $file_url = null;
        
        // Om bildfil finns i request
        if($request->hasFile('image')){

            if(!$request->file('image')->isValid()){
                return response()->json([
                    'error' => 'External error: File upload failed',
                    'message' => 'Upload failed because the file is not valid'
                ],400);
            }

            $file_path = $request->file('image')->store('images', env('STORAGE_DRIVER', 'local'));

            if(!$file_path){
                return response()->json([
                    'error' => 'Internal error: File upload failed',
                    'message' => 'The file could not be saved due to an internal error'
                ],500);
            }

            /** @var \Illuminate\Filesystem\FilesystemManager $disk */
            $disk = Storage::disk(env('STORAGE_DRIVER', 'local'));
            $file_url = $disk->url($file_path);
        }

        // Hämta autentiserad användare
        $user = $request->user();

        return Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'category'=> $request->category,
            'image_file' => $file_path,
            'image_url' => $file_url,
            'user_id' => $user->id,
        ]);
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
