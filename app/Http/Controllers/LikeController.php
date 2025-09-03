<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function likeDislike(Post $post)
    {
        // Logic | if user has already liked the post, remove like, else add like
        $hasLiked = $post->likes()->where('user_id', Auth::user()->id)->first();

        if ($hasLiked) {
            $hasLiked->delete();
        } else {
            $post->likes()->create([
                'user_id' => Auth::user()->id
            ]);
        }

        return response()->json([
            'likesCount' => $post->likes()->count()
        ]);
    }
}
