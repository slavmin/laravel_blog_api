<?php

namespace App\Concerns;

// Enums
use App\Enums\ImageSizes;

// MediaLibrary
use App\Models\MediaImage;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphMany;

// Exceptions
use Spatie\Image\Exceptions\InvalidManipulation;

trait HasMediaImages
{
    use InteractsWithMedia;


    public function media(): MorphMany
    {
        return $this->morphMany(MediaImage::class, 'model', null, null, 'uuid');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured_images')->singleFile(); //->withResponsiveImages();

        $this->addMediaCollection('post_images');
    }

    /**
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion(\Str::lower(ImageSizes::THUMB->name))
            ->performOnCollections('post_images', 'featured_images')
            ->fit(Manipulations::FIT_CROP, (int)ImageSizes::THUMB->value)
            ->nonOptimized();

        $this
            ->addMediaConversion(\Str::lower(ImageSizes::SMALL->name))
            ->performOnCollections('post_images', 'featured_images')
            ->fit(Manipulations::FIT_CROP, (int)ImageSizes::SMALL->value)
            ->nonOptimized();

        $this
            ->addMediaConversion(\Str::lower(ImageSizes::MEDIUM->name))
            ->performOnCollections('post_images', 'featured_images')
            ->fit(Manipulations::FIT_CROP, (int)ImageSizes::MEDIUM->value)
            ->nonOptimized();

        $this
            ->addMediaConversion(\Str::lower(ImageSizes::LARGE->name))
            ->performOnCollections('post_images', 'featured_images')
            ->fit(Manipulations::FIT_CROP, (int)ImageSizes::LARGE->value)
            ->nonOptimized();
    }
}
