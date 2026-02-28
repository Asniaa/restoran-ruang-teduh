<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationalDay extends Model
{
    use HasFactory;

    protected $table = 'operational_days';

    protected $fillable = [
        'tanggal',
        'status'
    ];

    protected $casts = [
        'tanggal' => 'date'
    ];

    // Relasi ke stok menu harian
    public function stokMenuHarian()
    {
        return $this->hasMany(StokMenuHarian::class, 'operational_day_id');
    }

    // Relasi ke pesanan
    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'operational_day_id');
    }
}