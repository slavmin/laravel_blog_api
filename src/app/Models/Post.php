<?php

namespace App\Models;

use App\Models\Concerns\HasTags;
use App\Models\Concerns\HasUuid;
use App\Models\Concerns\HasSlug;
use App\Models\Concerns\HasAuthor;
use App\Models\Concerns\HasCategories;
use App\Models\Concerns\HasMediaImages;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;

// Helpers
use Illuminate\Support\Str;

class Post extends Model implements \Spatie\MediaLibrary\HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use HasUuid;
    use HasSlug;
    use HasTags;
    use HasAuthor;
    use HasCategories;
    use HasMediaImages;

    const PER_PAGE = 16;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'content_blocks',
        'description',
        'featured_image',
        'original_author',
        'original_link',
        'type',
        'options',
        'featured',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'publish_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s',
        'options' => AsArrayObject::class,
    ];

    /**
     * {@inheritdoc}
     */
    protected $with = [
        'authorRelation',
        'tagsRelation',
        //'imagesRelation',
        'categoriesRelation',
    ];

    /**
     * {@inheritdoc}
     */
    public function getPerPage(): int
    {
        return static::PER_PAGE;
    }

    public function excerpt(int $limit = 100): string
    {
        return Str::limit(strip_tags($this->getAttribute('content')), $limit);
    }

    public function isPublished(): bool
    {
        return $this->getAttribute('published');
    }

    public function scopePublished(Builder $builder): void
    {
        $builder->where('published', true);
    }
}
