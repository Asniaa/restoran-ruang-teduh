<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory; // tambahkan ini

    protected $table = 'menu';

    protected $fillable = [
        'kategori_id',
        'nama_menu',
        'harga',
        'foto',
        'deskripsi',
        'aktif'
    ];

    // tambahkan ini untuk casting data
    protected $casts = [
        'harga' => 'decimal:2',
        'aktif' => 'boolean'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriMenu::class, 'kategori_id');
    }

    public function stokHarian()
    {
        return $this->hasMany(StokMenuHarian::class);
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class);
    }
}