<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // DB::listen(function ($query) {
        //     Log::info($query->sql, $query->bindings);
        // });


        // $posts = Post::orderBy('created_at', 'desc')->simplePaginate(5); // for simple pagination

        // Logic | Only authenticated user can see their as well as other user's posts whom the authenticated user follows

        $authUser = Auth::user();

        $query = Post::with(['user', 'media'])
            ->where('published_at', '<=', now())
            ->withCount('likes')
            ->orderBy('created_at', 'desc');

        if ($authUser) {
            $authUser_Id = $authUser->following()->pluck('users.id')->toArray();

            $query
                ->whereIn('user_id', $authUser_Id);
        }


        $posts = $query->paginate(5);

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostCreateRequest $request)
    {
        // Initial validation
        $data = $request->validated();

        // Handle image upload
        // $image = $data['image'];
        // unset($data['image']);
        // $imagePath = $image->store('posts', 'public');
        // $data['image'] = $imagePath;


        // Final Data Preparation
        $finalData = [
            ...$data,
            'user_id' => Auth::id()
        ];

        // Create the post
        $post = Post::create($finalData);

        // Media Conversion
        $post->addMediaFromRequest('image')->toMediaCollection();


        return redirect()->route('posts')->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $username, Post $post)
    {
        return view('posts.show', [
            'username' => $username,
            'post' => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        // Logic | show the edit form only if the authenticated user is the owner of the post

        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        // Logic | Also send the category id to the edit form


        $categories = Category::all();

        $post->with(['user', 'media'])->withCount('likes');

        // $oldImage = $post->imageUrl();
        $oldImage = $post->image ?? $post->getFirstMedia()['file_name'];

        return view('posts.edit', [
            'post' => $post,
            'categories' => $categories,
            'oldImage' => $oldImage
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        // Logic | Only authenticated user can edit their own posts
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        // Logic | At laest one of fields must be filled to update the post, reject empty requests
        $data = $request->validated();

        // Final Data Preparation
        $finalData = [
            ...$data,
            'updated_at' => now()
        ];

        // Update the post
        $post->update($finalData);

        // Media Conversion
        if ($data['image'] ?? false) {
            $post->clearMediaCollection();
            $post->addMediaFromRequest('image')
                ->toMediaCollection();
        }

        return redirect()->route('posts.myPosts', compact('post'))->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // Logic | Only authenticated user can delete their own posts

        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        $post->delete();

        return redirect()->route('posts')->with('success', 'Post deleted successfully.');
    }

    public function myPosts(Post $post)
    {
        // Logic | Only authenticated user can see their own posts where he is the owner of the post

        $posts = $post->where('user_id', Auth::id())
            ->with(['user', 'media'])
            ->withCount('likes')
            ->latest()->paginate(5);

        return view('posts.index', compact('posts'));
    }

    public function category(Category $category)
    {

        $authUser = Auth::user();

        $query = $category->posts()
            ->where('published_at', '<=', now())
            ->with(['user', 'media'])
            ->withCount('likes')
            ->latest();

        if ($authUser) {
            $authUser_Id = $authUser->following()->pluck('users.id')->toArray();

            $query
                ->whereIn('user_id', $authUser_Id);
        }

        $posts = $query->paginate(5);

        return view('posts.index', compact('posts'));
    }
}
