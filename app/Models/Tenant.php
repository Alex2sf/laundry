<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'logo', 'address', 'phone', 'email',
        'description', 'status', 'plan', 'plan_expires_at', 'settings',
    ];

    protected function casts(): array
    {
        return [
            'settings' => 'array',
            'plan_expires_at' => 'date',
        ];
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function owner()
    {
        return $this->users()->where('role', 'owner')->first();
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function getTotalRevenueAttribute(): float
    {
        return $this->orders()->whereIn('status', ['selesai', 'diambil'])->sum('total');
    }
}
