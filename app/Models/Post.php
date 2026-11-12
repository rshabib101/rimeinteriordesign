<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\App;

class Post extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'author_id',
        'title',
        'title_bn',
        'slug',
        'excerpt',
        'content',
        'cover_image',
        'category',
        'tags',
        'views_count',
        'is_published',
        'published_at',
        'meta_title',
        'meta_description',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
            'views_count' => 'integer',
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)->whereNotNull('published_at')->orderByDesc('published_at');
    }

    public function getLocalizedTitleAttribute(): string
    {
        if (App::getLocale() === 'bn' && !empty($this->title_bn)) {
            return $this->title_bn;
        }

        return $this->title;
    }
}

