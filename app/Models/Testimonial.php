<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Testimonial extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'client_name',
        'client_designation',
        'client_avatar',
        'project_name',
        'rating',
        'quote',
        'quote_bn',
        'is_featured',
        'sort_order',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true)->orderBy('sort_order', 'asc');
    }

    public function getLocalizedQuoteAttribute(): string
    {
        if (App::getLocale() === 'bn' && !empty($this->quote_bn)) {
            return $this->quote_bn;
        }

        return $this->quote;
    }
}

