<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;

use App\Policies\CategoryPolicy;
use App\Actions\Category\CategoryCreateAction;
use App\Actions\Category\CategoryUpdateAction;
use App\Http\Requests\Category\CategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * whereNull('parent_id') - for selecting root Categories with all children
     */
    public function index(): JsonResponse
    {
        $categories = Category::query()->whereNull('parent_id')->orderByDesc('created_at')->simplePaginate();

        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     * @throws AuthorizationException
     */
    public function store(CategoryRequest $request): JsonResponse
    {
        $this->authorize(CategoryPolicy::CREATE, Category::class);

        $category = CategoryCreateAction::fromRequest($request)->handle();

        return response()->json($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): JsonResponse
    {
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     * @throws AuthorizationException
     */
    public function update(CategoryRequest $request, Category $category): JsonResponse
    {
        $this->authorize(CategoryPolicy::UPDATE, $category);

        $category = CategoryUpdateAction::fromRequest($category, $request)->handle();

        return response()->json($category);
    }

    /**
     * Remove the specified resource from storage.
     * @throws AuthorizationException
     */
    public function destroy(Category $category): JsonResponse
    {
        $this->authorize(CategoryPolicy::DELETE, $category);

        $category->delete();

        return response()->json($category);
    }


    /**
     * Restore the specified resource to storage.
     * @throws AuthorizationException
     */
    public function restore(int $categoryID): JsonResponse
    {
        $category = Category::onlyTrashed()->findOrFail($categoryID);

        $this->authorize(CategoryPolicy::DELETE, $category);

        if ($category instanceof Category) {
            $category->restore();
        }

        return response()->json($category);
    }

    /**
     * Remove the specified resource forever.
     * @throws AuthorizationException
     */
    public function delete(int $categoryID): JsonResponse
    {
        $category = Category::onlyTrashed()->findOrFail($categoryID);

        $this->authorize(CategoryPolicy::DELETE, $category);

        $category->forceDelete();

        return response()->json(['message' => 'Rest in peace...']);
    }
}
