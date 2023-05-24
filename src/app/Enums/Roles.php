<?php

namespace App\Enums;

enum Roles: string
{
    case READER = 'READER';
    case PUBLISHER = 'PUBLISHER';
    case EDITOR = 'EDITOR';
    case MODERATOR = 'MODERATOR';
    case ADMIN = 'ADMIN';

    public static function rolesList(): array
    {
        $arr = [];

        foreach (self::cases() as $case) {
            $arr[] = $case->value;
        }

        return $arr;
    }
}
