<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

trait HasSlug
{
    protected string $slug;

    public function slug(): string
    {
        return $this->slug;
    }

    public function setSlugAttribute(string $slug): void
    {
        $this->attributes['slug'] = $this->generateUniqueSlug($slug);
    }

    public static function findBySlug(string $slug): self
    {
        return self::where('slug', $slug)->firstOrFail();
    }

    private function generateUniqueSlug(string $value): string
    {
        $slug = $originalSlug = Str::slug($value) ?: Str::random(5);
        $counter = 0;

        while ($this->slugExists($slug, $this->exists ? $this->getAttribute('id') : null)) {
            $counter++;
            $slug = $originalSlug . '-' . $counter;
        }

        return $slug;
    }

    private function slugExists(string $slug, int $ignoreId = null): bool
    {
        $query = $this->withTrashed()->where('slug', $slug);

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        return $query->exists();
    }
}
