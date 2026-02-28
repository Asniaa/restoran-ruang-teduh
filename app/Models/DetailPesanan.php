<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    use HasFactory;

    protected $table = 'detail_pesanan';

    protected $fillable = [
        'pesanan_id',
        'menu_id',
        'kuantitas',
        'catatan',
        'harga_saat_pesan'
    ];

    // Relasi ke pesanan
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }

    // Relasi ke menu
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}