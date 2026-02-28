<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payment';

    protected $fillable = [
        'pesanan_id',
        'karyawan_id',
        'metode_pembayaran',
        'total_bayar',
        'jumlah_bayar',
        'kembalian',
        'waktu_bayar'
    ];

    protected $casts = [
        'total_bayar' => 'decimal:2',
        'jumlah_bayar' => 'decimal:2',
        'kembalian' => 'decimal:2',
        'waktu_bayar' => 'datetime'
    ];

    // Relasi ke pesanan
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }

    // Relasi ke karyawan
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }
}