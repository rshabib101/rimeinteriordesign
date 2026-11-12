<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Resolves media paths seamlessly whether stored as full external URLs or local public disk paths.
 */
final class MediaHelper
{
    public static function url(?string $path, ?string $fallback = null): ?string
    {
        if (blank($path)) {
            return $fallback;
        }

        if (Str::startsWith($path, ['http://', 'https://', '//', '/'])) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }

    /**
     * Resolve an array of mixed URL/storage paths.
     *
     * @param  array<int, string>|null  $paths
     * @return array<int, string>
     */
    public static function urls(?array $paths): array
    {
        if (empty($paths)) {
            return [];
        }

        return array_values(array_filter(array_map(
            static fn (?string $path): ?string => self::url($path),
            $paths
        )));
    }
}

