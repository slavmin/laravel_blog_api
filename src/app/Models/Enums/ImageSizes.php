<?php

namespace App\Models\Enums;

enum ImageSizes: string
{
    case THUMB = '240';
    case SMALL = '480';
    case MEDIUM = '960';
    case LARGE = '1440';

    public static function imageSizesList(): array
    {
        $arr = [];

        foreach (self::cases() as $case) {
            $arr[] = $case->value;
        }

        return $arr;
    }
}
