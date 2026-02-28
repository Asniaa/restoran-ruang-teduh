<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokMenuHarian extends Model
{
    use HasFactory;

    protected $table = 'stok_menu_harian';

    protected $fillable = [
        'operational_day_id',
        'menu_id',
        'stok'
    ];

    // Relasi ke operational day
    public function operationalDay()
    {
        return $this->belongsTo(OperationalDay::class, 'operational_day_id');
    }

    // Relasi ke menu
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}