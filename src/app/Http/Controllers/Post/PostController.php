<?php

namespace App\Http\Controllers\Post;

use App\Models\Post;
use App\Policies\PostPolicy;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PostRequest;
use Illuminate\Auth\Access\AuthorizationException;

use App\Actions\Post\PostCreateAction;
use App\Actions\Post\PostUpdateAction;
use App\Actions\Post\PostDestroyAction;
use App\Actions\Post\PostForceDeleteAction;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $posts = Post::query()->orderByDesc('created_at')->simplePaginate();

        return response()->json($posts);
    }

    /**
     * Store a newly created resource in storage.
     * @throws AuthorizationException
     */
    public function store(PostRequest $request): JsonResponse
    {
        //dd($request->allFiles());

        $this->authorize(PostPolicy::CREATE, Post::class);

        $post = PostCreateAction::fromRequest($request)->handle();

        $post->addMedia($request->file('featured_image'))->toMediaCollection('featured_images');

        return response()->json($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): JsonResponse
    {
        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     * @throws AuthorizationException
     */
    public function update(PostRequest $request, Post $post): JsonResponse
    {
        $this->authorize(PostPolicy::UPDATE, $post);

        $post = PostUpdateAction::fromRequest($post, $request)->handle();

        return response()->json($post);
    }

    /**
     * Remove the specified resource from storage.
     * @throws AuthorizationException
     */
    public function destroy(Post $post): JsonResponse
    {
        $this->authorize(PostPolicy::DELETE, $post);

        (new PostDestroyAction($post))->handle();

        return response()->json($post);
    }

    /**
     * Restore the specified resource to storage.
     * @throws AuthorizationException
     */
    public function restore(int $postID): JsonResponse
    {
        $post = Post::onlyTrashed()->findOrFail($postID);

        $this->authorize(PostPolicy::DELETE, $post);

        if ($post instanceof Post) {
            $post->restore();
        }

        return response()->json($post);
    }

    /**
     * Remove the specified resource forever.
     * @throws AuthorizationException
     */
    public function delete(int $postID): JsonResponse
    {
        $post = Post::onlyTrashed()->findOrFail($postID);

        $this->authorize(PostPolicy::DELETE, $post);

        if ($post instanceof Post) {
            (new PostForceDeleteAction($post))->handle();
        }

        return response()->json(['message' => 'Rest in peace...']);
    }
}
