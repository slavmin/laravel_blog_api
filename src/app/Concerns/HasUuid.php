<?php

namespace App\Concerns;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

trait HasUuid
{
    public static function bootHasUuid(): void
    {
        static::creating(fn(Model $model) => $model->attributes['uuid'] = (string)Str::uuid());
    }

    public static function findByUuid(string $uuid): ?Model
    {
        return static::where('uuid', $uuid)->first();
    }
}
