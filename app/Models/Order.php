<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id', 'user_id', 'customer_id', 'invoice_number',
        'subtotal', 'discount_amount', 'tax_amount',
        'total', 'paid_amount', 'change_amount', 'payment_method',
        'payment_status', 'status', 'estimated_done_at', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'tenant_id' => 'integer',
            'subtotal' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'total' => 'decimal:2',
            'paid_amount' => 'decimal:2',
            'change_amount' => 'decimal:2',
            'estimated_done_at' => 'datetime',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateInvoiceNumber(int $tenantId): string
    {
        $prefix = 'LDR-' . $tenantId;
        $date = now()->format('Ymd');

        $latest = static::where('tenant_id', $tenantId)
            ->whereDate('created_at', today())
            ->orderBy('id', 'desc')
            ->first();

        if ($latest) {
            $latestCount = (int) substr($latest->invoice_number, -4);
            $count = $latestCount + 1;
        } else {
            $count = 1;
        }

        return sprintf('%s-%s-%04d', $prefix, $date, $count);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'antrian' => 'badge-warning',
            'proses'  => 'badge-info',
            'selesai' => 'badge-success',
            'diambil' => 'badge-secondary',
            'batal'   => 'badge-danger',
            default   => 'badge-info',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'antrian' => '🕐 Antrian',
            'proses'  => '🔄 Proses',
            'selesai' => '✅ Selesai',
            'diambil' => '📦 Diambil',
            'batal'   => '❌ Batal',
            default   => $this->status,
        };
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        return match($this->payment_status) {
            'lunas'       => '💰 Lunas',
            'dp'          => '💳 DP',
            'belum_bayar' => '⏳ Belum Bayar',
            default       => $this->payment_status,
        };
    }
}
