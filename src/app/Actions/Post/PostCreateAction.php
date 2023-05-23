<?php

namespace App\Actions\Post;

use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Str;
use App\Http\Requests\Post\PostRequest;

final class PostCreateAction
{
    public function __construct(
        private readonly string  $title,
        private readonly string  $content,
        private readonly ?string $description,
        private readonly User    $author,
        private readonly array   $tags,
        private readonly array   $categories,
        // private readonly bool    $featured,
    )
    {
    }

    public static function fromRequest(PostRequest $request): self
    {
        return new self(
            $request->title(),
            $request->content(),
            $request->description(),
            $request->author(),
            $request->tags(),
            $request->categories(),
        // $request->input('featured'),
        );
    }

    public function handle(): Post
    {
        $post = new Post([
            'title' => $this->title,
            'slug' => $this->title,
            'description' => $this->description,
            'content' => $this->content,
            // 'featured' => $this->featured,
        ]);

        $post->authoredBy($this->author);

        $post->save();

        $post->syncTags($this->tags);

        $post->syncCategories($this->categories);

        return $post->fresh();
    }
}
