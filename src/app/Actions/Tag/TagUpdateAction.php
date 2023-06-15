<?php

namespace App\Actions\Tag;

use App\Models\Tag;
use App\Http\Requests\Tag\TagRequest;

final class TagUpdateAction
{
    public function __construct(
        private readonly Tag     $tag,
        private readonly string  $title,
        private readonly ?string $slug,
        private readonly ?string $description,
        // private readonly bool    $featured,
    ) {
    }

    public static function fromRequest(Tag $tag, TagRequest $request): self
    {
        return new self(
            $tag,
            $request->title(),
            $request->input('slug'),
            $request->description(),
            // $request->input('featured'),
        );
    }

    public function handle(): ?Tag
    {
        $this->tag->update([
            'title' => $this->title,
            'slug' => !empty($this->slug) ? $this->slug : $this->title,
            'description' => $this->description,
            // 'featured' => $this->featured,
        ]);

        $this->tag->save();

        return $this->tag->fresh();
    }
}
