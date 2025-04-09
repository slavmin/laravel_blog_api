<?php

namespace App\Models;

use App\Concerns\HasUuid;
use App\Concerns\HasSlug;
use App\Concerns\HasAuthor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasAuthor;
    use HasFactory;
    use HasSlug;
    use HasUuid;
    use SoftDeletes;

    public const PER_PAGE = 100;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
    ];

    /**
     * {@inheritdoc}
     */
    protected $with = [
        // 'authorRelation',
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
    ];

    public function posts(): MorphToMany
    {
        return $this->morphedByMany(Post::class, 'taggable', null, null, null, 'uuid', 'uuid');
    }

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
}
