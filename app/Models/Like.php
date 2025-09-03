<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Post;

class Like extends Model
{
    public const UPDATED_AT = null;

    protected $table = 'likes';

    protected $fillable = [
        'user_id',
        'post_id',
    ];


    // Relationship with the User model [Many to One]
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with the Post model [Many to One]
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
