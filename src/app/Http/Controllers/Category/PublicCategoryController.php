<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use App\Http\Controllers\Controller;
// Resource
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Category\CategoryCollection;

class PublicCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * whereNull('parent_id') - for selecting root Categories with all children
     */
    public function index(): CategoryCollection
    {
        $categories = Category::query()->whereNull('parent_id')->orderByDesc('created_at')->paginate();

        return new CategoryCollection($categories);
    }

    /**
     * Display the specified resource.
     */
    public function showBySlug(string $slug): CategoryResource
    {
        $category = Category::query()->published()->where('slug', $slug)->firstOrFail();

        return new CategoryResource($category);
    }
}
