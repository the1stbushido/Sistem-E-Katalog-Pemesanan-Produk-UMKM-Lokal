<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',         // <-- INI PERBAIKANNYA
        'quantity',
        'price_at_purchase',    // <-- INI PERBAIKANNYA
        'sub_total',            // <-- INI PERBAIKANNYA
        // 'price' yang lama dihapus
    ];

    /**
     * Relasi ke Order.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relasi ke Product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price_at_purchase' => 'decimal:2',
            'sub_total' => 'decimal:2',
        ];
    }
}