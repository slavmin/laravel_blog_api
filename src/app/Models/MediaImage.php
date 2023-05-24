<?php

namespace App\Models;

use Spatie\Image\Manipulations;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;

// Enums
use App\Enums\ImageSizes;

// Exceptions
use Spatie\Image\Exceptions\InvalidManipulation;

class MediaImage extends BaseMedia implements \Spatie\MediaLibrary\HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
}
