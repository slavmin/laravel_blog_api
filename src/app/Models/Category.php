<?php

namespace App\Models;

use App\Concerns\HasSlug;
use App\Concerns\HasUuid;
use App\Concerns\HasAuthor;
use App\Concerns\HasMediaImages;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Category extends Model implements \Spatie\MediaLibrary\HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use HasUuid;
    use HasSlug;
    use HasAuthor;
    use HasMediaImages;

    const PER_PAGE = 100;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'title',
        'slug',
        'parent_id',
        'content',
        'description',
        'image',
        'options',
    ];

    /**
     * {@inheritdoc}
     */
    protected $hidden = [
        'pivot',
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
        'childrenCategories',
        // 'authorRelation',
    ];

    /**
     * {@inheritdoc}
     */
    public function getPerPage(): int
    {
        return static::PER_PAGE;
    }

    public function isPublished(): bool
    {
        return $this->getAttribute('published');
    }

    public function scopePublished(Builder $builder): void
    {
        $builder->where('published', true);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id', 'uuid');
    }

    public function childrenCategories(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id', 'uuid')->with('categories');
    }

    public function posts(): MorphToMany
    {
        return $this->morphedByMany(Post::class, 'categorizable', null, null, null, 'uuid', 'uuid');
    }
}
