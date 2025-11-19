<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // <-- Tambahkan ini jika belum ada

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        // 'order_code', // Kita akan set ini menggunakan 'creating' event
        'table_number',
        'total_amount',
        'status',
        'payment_method',     // <-- INI DIA PERBAIKANNYA (sebelumnya 'payment_type')
        'payment_token',      // <-- INI JUGA HARUS ADA
        'paid_at',            // <-- INI JUGA HARUS ADA
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    /**
     * Relasi ke OrderItems.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    
    /**
     * Boot function untuk auto-generate order_code (jika Anda mau)
     * Tapi sepertinya controller Anda sudah menanganinya, jadi ini opsional.
     * Kita biarkan saja $fillable yang diperbaiki.
     */
}