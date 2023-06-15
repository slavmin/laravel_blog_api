<?php

namespace App\Http\Controllers\Tag;

use App\Models\Tag;
use App\Policies\TagPolicy;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\TagRequest;
use Illuminate\Auth\Access\AuthorizationException;

// Actions
use App\Actions\Tag\TagCreateAction;
use App\Actions\Tag\TagUpdateAction;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $tags = Tag::query()->get();

        return response()->json($tags);
    }

    /**
     * Store a newly created resource in storage.
     * @throws AuthorizationException
     */
    public function store(TagRequest $request): JsonResponse
    {
        $this->authorize(TagPolicy::CREATE, Tag::class);

        $tag = TagCreateAction::fromRequest($request)->handle();

        return response()->json($tag);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag): JsonResponse
    {
        return response()->json($tag);
    }

    /**
     * Update the specified resource in storage.
     * @throws AuthorizationException
     */
    public function update(TagRequest $request, Tag $tag): JsonResponse
    {
        $this->authorize(TagPolicy::UPDATE, $tag);

        $tag = TagUpdateAction::fromRequest($tag, $request)->handle();

        return response()->json($tag);
    }

    /**
     * Remove the specified resource from storage.
     * @throws AuthorizationException
     */
    public function destroy(Tag $tag): JsonResponse
    {
        $this->authorize(TagPolicy::DELETE, $tag);

        $tag->delete();

        return response()->json($tag);
    }

    /**
     * Restore the specified resource to storage.
     * @throws AuthorizationException
     */
    public function restore(int $tagID): JsonResponse
    {
        $tag = Tag::onlyTrashed()->findOrFail($tagID);

        $this->authorize(TagPolicy::DELETE, $tag);

        if ($tag instanceof Tag) {
            $tag->restore();
        }

        return response()->json($tag);
    }

    /**
     * Remove the specified resource forever.
     * @throws AuthorizationException
     */
    public function delete(int $tagID): JsonResponse
    {
        $tag = Tag::onlyTrashed()->findOrFail($tagID);

        $this->authorize(TagPolicy::DELETE, $tag);

        $tag->forceDelete();

        return response()->json(['message' => 'Rest in peace...']);
    }
}
