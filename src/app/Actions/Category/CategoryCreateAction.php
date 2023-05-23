<?php

namespace App\Actions\Category;

use App\Models\User;
use App\Models\Category;
use App\Http\Requests\Category\CategoryRequest;

final class CategoryCreateAction
{
    public function __construct(
        private readonly string  $title,
        private readonly ?string $slug,
        private readonly ?string $description,
        private readonly User    $author,
        private readonly ?string $parent_id,
    )
    {
    }

    public static function fromRequest(CategoryRequest $request): self
    {
        return new self(
            $request->title(),
            $request->input('slug'),
            $request->description(),
            $request->author(),
            $request->input('parent_id'),
        );
    }

    public function handle(): ?Category
    {
        $category = new Category([
            'title' => $this->title,
            'slug' => !empty($this->slug) ? $this->slug : $this->title,
            'description' => $this->description,
            'parent_id' => $this->parent_id,
        ]);

        $category->authoredBy($this->author);

        $category->save();

        return $category->fresh();
    }
}
