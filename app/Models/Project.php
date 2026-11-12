<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\App;

class Project extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'category_id',
        'title',
        'title_bn',
        'slug',
        'room_type',
        'style',
        'area_sqft',
        'location',
        'duration',
        'completion_year',
        'client_name',
        'summary',
        'description',
        'cover_image',
        'before_image',
        'after_image',
        'gallery_images',
        'model_3d_path',
        'is_featured',
        'is_published',
        'sort_order',
        'meta_title',
        'meta_description',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'gallery_images' => 'array',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'sort_order' => 'integer',
            'area_sqft' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)->orderBy('sort_order', 'asc');
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_published', true)->where('is_featured', true)->orderBy('sort_order', 'asc');
    }

    public function getLocalizedTitleAttribute(): string
    {
        if (App::getLocale() === 'bn' && !empty($this->title_bn)) {
            return $this->title_bn;
        }

        return $this->title;
    }
}

