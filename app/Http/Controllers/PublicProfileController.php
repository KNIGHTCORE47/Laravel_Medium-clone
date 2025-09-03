<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PublicProfileController extends Controller
{
    public function show(User $user)
    {
        // User All posts
        $posts = $user->posts()
            ->where('published_at', '<=', now())
            ->withCount(['likes', 'media'])
            ->latest()
            ->paginate(5);

        return view('profile.show', compact('user'), compact('posts'));
    }
}
