<?php

namespace App\Actions\Post;

use App\Models\User;
use App\Models\Post;
use App\Http\Requests\Post\PostRequest;

final class PostUpdateAction
{
    public function __construct(
        private readonly Post    $post,
        private readonly string  $title,
        private readonly string  $content,
        private readonly ?string $description,
        private readonly array   $tags,
        private readonly array   $categories,
        // private readonly bool    $featured,
    )
    {
    }

    public static function fromRequest(Post $post, PostRequest $request): self
    {
        return new self(
            $post,
            $request->title(),
            $request->content(),
            $request->description(),
            $request->tags(),
            $request->categories(),
        // $request->input('featured'),
        );
    }

    public function handle(): Post|\Illuminate\Database\Eloquent\Collection
    {
        $this->post->update([
            'title' => $this->title,
            // 'slug' => $this->title,
            'description' => $this->description,
            'content' => $this->content,
            // 'featured' => $this->featured,
        ]);

        $this->post->syncTags($this->tags);

        $this->post->syncCategories($this->categories);

        return $this->post->fresh();
    }
}
