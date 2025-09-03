<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FollowerController extends Controller
{
    public function followUnfollow(User $user)
    {
        $user->followers()->toggle(Auth::user());

        return response()->json([
            'followersCount' => $user->followers()->count()
        ], 200);
    }
}
