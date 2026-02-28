<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // First, delete duplicate records, keeping only the first occurrence
        // for each unique kategori name
        $duplicates = DB::table('kategori_menu')
            ->selectRaw('MIN(id) as keep_id, nama_kategori')
            ->groupBy('nama_kategori')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($duplicates as $dup) {
            DB::table('kategori_menu')
                ->where('nama_kategori', $dup->nama_kategori)
                ->where('id', '!=', $dup->keep_id)
                ->delete();
        }

        // Then add unique constraint
        Schema::table('kategori_menu', function (Blueprint $table) {
            $table->unique('nama_kategori');
        });
    }

    public function down(): void
    {
        Schema::table('kategori_menu', function (Blueprint $table) {
            $table->dropUnique(['nama_kategori']);
        });
    }
};
