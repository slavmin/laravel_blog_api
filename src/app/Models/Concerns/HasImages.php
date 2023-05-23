<?php

namespace App\Models\Concerns;

use App\Models\Image;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasImages
{
    public function images(): MorphToMany
    {
        return $this->imagesRelation();
    }

    public function imagesRelation(): MorphToMany
    {
        return $this->morphToMany(Image::class, 'imageable', null, null, null, 'uuid', 'uuid');
    }

    public function syncImages(array $images): void
    {
        $this->imagesRelation()->sync($images);
    }

    public function removeImages(): void
    {
        $this->imagesRelation()->detach();
    }
}
