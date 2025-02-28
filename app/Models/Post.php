<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $fillable = ['title', 'content', 'category', 'user_id', 'image_file', 'image_url' ];

    // Ett inlägg kan ha många kommentarer
    public function comments(){
        return $this->hasMany(Comment::class); 
    }
}
