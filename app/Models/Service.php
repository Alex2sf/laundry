<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id', 'name', 'type', 'speed', 'price',
        'unit', 'estimated_hours', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function getSpeedLabelAttribute(): string
    {
        return match($this->speed) {
            'express' => '⚡ Express (6 Jam)',
            'kilat'   => '🔥 Kilat (24 Jam)',
            default   => '📦 Reguler (2-3 Hari)',
        };
    }
}
