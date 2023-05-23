<?php

namespace App\Models\Concerns;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasAuthor
{
    public function author(): BelongsTo
    {
        return $this->authorRelation();
    }

    public function authorRelation(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id', 'uuid')->withDefault();
    }

    public function authoredBy(User $author): void
    {
        $this->authorRelation()->associate($author);

        $this->unsetRelation('authorRelation');
    }

    public function isAuthoredBy(User $user): bool
    {
        return $this->author()->is($user);
    }
}
