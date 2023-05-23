<?php

namespace App\Models\Concerns;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasCategories
{
    public function categories(): MorphToMany
    {
        return $this->categoriesRelation();
    }

    public function categoriesRelation(): MorphToMany
    {
        return $this->morphToMany(Category::class, 'categorizable', null, null, null, 'uuid', 'uuid');
    }

    public function syncCategories(array $categories): void
    {
        $this->categoriesRelation()->sync($categories);
    }

    public function removeCategories(): void
    {
        $this->categoriesRelation()->detach();
    }
}
