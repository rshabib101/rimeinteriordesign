<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class TeamMember extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'role',
        'role_bn',
        'bio',
        'photo',
        'linkedin_url',
        'instagram_url',
        'sort_order',
        'is_active',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order', 'asc');
    }

    public function getLocalizedRoleAttribute(): string
    {
        if (App::getLocale() === 'bn' && !empty($this->role_bn)) {
            return $this->role_bn;
        }

        return $this->role;
    }
}

