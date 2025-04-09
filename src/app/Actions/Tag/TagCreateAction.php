<?php

namespace App\Actions\Tag;

use App\Models\Tag;
use App\Models\User;
use App\Http\Requests\Tag\TagRequest;

final class TagCreateAction
{
    public function __construct(
        private readonly string  $title,
        private readonly ?string $slug,
        private readonly ?string $description,
        private readonly User    $author,
        // private readonly bool    $featured,
    ) {
    }

    public static function fromRequest(TagRequest $request): self
    {
        return new self(
            $request->title(),
            $request->input('slug'),
            $request->description(),
            $request->author(),
            // $request->input('featured'),
        );
    }

    public function handle(): ?Tag
    {
        $tag = new Tag([
            'title' => $this->title,
            'slug' => ! empty($this->slug) ? $this->slug : $this->title,
            'description' => $this->description,
            // 'featured' => $this->featured,
        ]);

        $tag->authoredBy($this->author);

        $tag->save();

        return $tag->fresh();
    }
}
