<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'key',
        'value',
        'group',
    ];

    /**
     * Get setting value by key with optional default.
     */
    public static function get(string $key, ?string $default = null): ?string
    {
        try {
            return Cache::rememberForever("setting.{$key}", function () use ($key, $default): ?string {
                $setting = static::where('key', $key)->first();

                return ($setting && $setting->value !== null && $setting->value !== '') ? $setting->value : $default;
            });
        } catch (\Throwable) {
            return $default;
        }
    }

    /**
     * Get localized setting (looks for "{$key}_bn" when locale is bn, falling back to "{$key}").
     */
    public static function localized(string $key, ?string $default = null): ?string
    {
        if (App::getLocale() === 'bn') {
            $bnValue = static::get("{$key}_bn");
            if (!empty($bnValue)) {
                return $bnValue;
            }
        }

        return static::get($key, $default);
    }

    /**
     * Get JSON-decoded setting array.
     *
     * @param  array<mixed>  $default
     * @return array<mixed>
     */
    public static function json(string $key, array $default = []): array
    {
        $raw = static::get($key);
        if (empty($raw)) {
            return $default;
        }

        $decoded = json_decode($raw, true);

        return is_array($decoded) ? $decoded : $default;
    }

    /**
     * Set setting value by key.
     */
    public static function set(string $key, ?string $value, string $group = 'general'): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group]
        );

        Cache::forget("setting.{$key}");
    }
}
