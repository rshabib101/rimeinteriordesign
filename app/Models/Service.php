<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\App;

class Service extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'title_bn',
        'slug',
        'icon',
        'short_description',
        'short_description_bn',
        'full_description',
        'features',
        'starting_price_bdt',
        'process_steps',
        'banner_image',
        'sort_order',
        'is_featured',
        'is_active',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'features' => 'array',
            'process_steps' => 'array',
            'starting_price_bdt' => 'decimal:2',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(Inquiry::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order', 'asc');
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_active', true)->where('is_featured', true)->orderBy('sort_order', 'asc');
    }

    public function getLocalizedTitleAttribute(): string
    {
        if (App::getLocale() === 'bn' && !empty($this->title_bn)) {
            return $this->title_bn;
        }

        return $this->title;
    }

    public function getLocalizedShortDescriptionAttribute(): ?string
    {
        if (App::getLocale() === 'bn' && !empty($this->short_description_bn)) {
            return $this->short_description_bn;
        }

        return $this->short_description;
    }
}

