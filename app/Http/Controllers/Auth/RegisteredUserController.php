<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        // Security Trim [user name, username, email and bio]
        $request->name = trim($request->name);
        $request->email = trim($request->email);
        $request->username = trim($request->username);
        $request->bio = trim($request->bio);


        // Generate User Avatar [Hard Coded Avatar]
        $user_avatar = "https://ui-avatars.com/api/?name=" . urlencode($request->name) . "&background=random";

        $user = User::create([
            'username' => Str::slug($request->name) . '-' . Str::random(6),
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => $user_avatar,
            'bio' => $request->bio ?? null
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('posts', absolute: false));
    }
}
