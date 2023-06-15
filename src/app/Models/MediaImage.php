<?php

namespace App\Models;

use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;

// Enums

// Exceptions

class MediaImage extends BaseMedia implements \Spatie\MediaLibrary\HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
}
