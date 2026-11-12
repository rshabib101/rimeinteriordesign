<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Inquiry extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'booking_number',
        'name',
        'email',
        'phone',
        'service_id',
        'property_type',
        'budget_range',
        'area_sqft',
        'preferred_date',
        'preferred_time',
        'floor_plan_path',
        'message',
        'status',
        'admin_notes',
    ];

    /**
     * Automatically assign a unique booking number when creating an inquiry.
     */
    protected static function booted(): void
    {
        static::creating(function (Inquiry $inquiry): void {
            if (empty($inquiry->booking_number)) {
                $inquiry->booking_number = 'RIME-' . now()->format('Y') . '-' . strtoupper(Str::random(5));
            }
            if (empty($inquiry->status)) {
                $inquiry->status = 'New';
            }
        });
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'preferred_date' => 'date',
            'area_sqft' => 'integer',
        ];
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
