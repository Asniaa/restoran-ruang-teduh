<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';

    protected $fillable = [
        'operational_day_id',
        'meja_id',
        'jenis_pesanan',
        'status',
        'ditangani_oleh',
        'waktu_pesan'
    ];

    protected $casts = [
        'waktu_pesan' => 'datetime'
    ];

    // Relasi ke detail pesanan
    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id');
    }

    // Relasi ke meja
    public function meja()
    {
        return $this->belongsTo(Meja::class, 'meja_id');
    }

    // Relasi ke operational day
    public function operationalDay()
    {
        return $this->belongsTo(OperationalDay::class, 'operational_day_id');
    }

    // Relasi ke karyawan yang menangani
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'ditangani_oleh');
    }

    // Relasi ke payment
    public function payment()
    {
        return $this->hasOne(Payment::class, 'pesanan_id');
    }
}