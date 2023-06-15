<?php

namespace App\Actions\Category;

use App\Models\Category;
use App\Http\Requests\Category\CategoryRequest;

final class CategoryUpdateAction
{
    public function __construct(
        private readonly Category $category,
        private readonly string   $title,
        private readonly ?string  $slug,
        private readonly ?string  $description,
        private readonly ?string  $parent_id,
    ) {
    }

    public static function fromRequest(Category $category, CategoryRequest $request): self
    {
        return new self(
            $category,
            $request->title(),
            $request->input('slug'),
            $request->description(),
            $request->input('parent_id'),
        );
    }

    public function handle(): ?Category
    {
        $this->category->update([
            'title' => $this->title,
            'slug' => !empty($this->slug) ? $this->slug : $this->title,
            'description' => $this->description,
            'parent_id' => $this->parent_id,
        ]);

        return $this->category->fresh();
    }
}
