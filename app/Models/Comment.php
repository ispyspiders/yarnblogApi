<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['user_id', 'post_id', 'comment'];

    // En kommentar tillhör en användare
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // En kommentar tillhör ett inlägg
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
