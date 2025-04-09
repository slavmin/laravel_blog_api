<?php

namespace App\Http\Controllers\Post;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Category;
use App\Http\Controllers\Controller;
// Resources
use App\Http\Resources\Post\PostResource;
use App\Http\Resources\Post\PostCollection;

class PublicPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): PostCollection
    {
        $posts = Post::query()->published()->orderByDesc('created_at')->paginate();

        return new PostCollection($posts);
    }

    /**
     * Display the specified resource.
     */
    public function showBySlug(string $slug): PostResource
    {
        $post = Post::query()->published()->where('slug', $slug)->firstOrFail();

        return new PostResource($post);
    }

    /**
     * Display a listing of the resource by Tag.
     */
    public function showByTag(string $slug): PostCollection
    {
        $tag = Tag::query()->published()->where('slug', $slug)->firstOrFail();

        $posts = $tag->posts()->orderByDesc('created_at')->paginate();

        return new PostCollection($posts);
    }

    /**
     * Display a listing of the resource by Category.
     */
    public function showByCategory(string $slug): PostCollection
    {
        $category = Category::query()->published()->where('slug', $slug)->firstOrFail();

        $posts = $category->posts()->orderByDesc('created_at')->paginate();

        return new PostCollection($posts);
    }
}
