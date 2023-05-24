<?php

namespace App\Concerns;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasTags
{
    public function tags(): MorphToMany
    {
        return $this->tagsRelation();
    }

    public function tagsRelation(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable', null, null, null, 'uuid', 'uuid');
    }

    public function syncTags(array $tags): void
    {
        $this->tagsRelation()->sync($tags);
    }

    public function removeTags(): void
    {
        $this->tagsRelation()->detach();
    }
}
