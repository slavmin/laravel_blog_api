<?php

namespace App\Http\Controllers\Tag;

use App\Models\Tag;
use App\Http\Controllers\Controller;
// Resource
use App\Http\Resources\Tag\TagResource;
use App\Http\Resources\Tag\TagCollection;

class PublicTagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): TagCollection
    {
        $tags = Tag::query()->published()->paginate();

        return new TagCollection($tags);
    }

    /**
     * Display the specified resource.
     */
    public function showBySlug(string $slug): TagResource
    {
        $tag = Tag::query()->published()->where('slug', $slug)->firstOrFail();

        return new TagResource($tag);
    }
}
