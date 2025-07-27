<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'order_code',
        'customer_name',
        'customer_email',
        'customer_phone',
        'status',
        'total_amount',
        'payment_status',
        'notes',
    ];

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    // Helper method untuk status order yang konsisten
    public function getStatusLabelAttribute()
    {
        $statusMap = [
            'quotation' => 'Penawaran',
            'waiting_payment' => 'Menunggu Pembayaran',
            'in_production' => 'Diproses',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];

        return $statusMap[$this->status] ?? $this->status;
    }

    // Helper method untuk status pembayaran yang konsisten
    public function getPaymentStatusLabelAttribute()
    {
        $paymentStatusMap = [
            'unpaid' => 'Belum Dibayar',
            'down_payment' => 'DP Dibayar',
            'paid' => 'Lunas',
        ];

        return $paymentStatusMap[$this->payment_status] ?? $this->payment_status;
    }

    // Helper method untuk warna status order
    public function getStatusColorAttribute()
    {
        $colorMap = [
            'quotation' => 'bg-blue-100 text-blue-700',
            'waiting_payment' => 'bg-yellow-100 text-yellow-700',
            'in_production' => 'bg-orange-100 text-orange-700',
            'completed' => 'bg-green-100 text-green-700',
            'cancelled' => 'bg-red-100 text-red-700',
        ];

        return $colorMap[$this->status] ?? 'bg-gray-100 text-gray-700';
    }

    // Helper method untuk warna status pembayaran
    public function getPaymentStatusColorAttribute()
    {
        $colorMap = [
            'unpaid' => 'bg-red-100 text-red-700',
            'down_payment' => 'bg-yellow-100 text-yellow-700',
            'paid' => 'bg-green-100 text-green-700',
        ];

        return $colorMap[$this->payment_status] ?? 'bg-gray-100 text-gray-700';
    }

    // Method untuk mengecek apakah order sudah dibayar
    public function isPaid()
    {
        return in_array($this->payment_status, ['paid', 'down_payment']);
    }

    // Method untuk mengecek apakah order sudah lunas
    public function isFullyPaid()
    {
        return $this->payment_status === 'paid';
    }

    // Method untuk mengecek apakah order sudah selesai
    public function isCompleted()
    {
        return $this->status === 'completed';
    }
} 