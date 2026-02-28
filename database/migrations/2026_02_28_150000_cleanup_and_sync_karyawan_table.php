<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Models\Karyawan;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Hapus karyawan yang tidak punya relasi user yang valid
        Karyawan::whereDoesntHave('user')->delete();

        // 2. Cari user_id duplikat di tabel karyawan
        $duplicateUserIds = DB::table('karyawan')
            ->select('user_id')
            ->groupBy('user_id')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('user_id');

        // 3. Untuk setiap user_id duplikat, simpan satu record dan hapus sisanya
        foreach ($duplicateUserIds as $userId) {
            // Ambil semua ID karyawan untuk user_id ini
            $karyawanIds = Karyawan::where('user_id', $userId)->orderBy('id')->pluck('id');
            
            // Simpan ID pertama, hapus sisanya
            $idsToDelete = $karyawanIds->slice(1);
            
            if ($idsToDelete->isNotEmpty()) {
                Karyawan::whereIn('id', $idsToDelete)->delete();
            }
        }

        // 4. Sinkronkan nama dari tabel users ke karyawan
        $karyawansToUpdate = Karyawan::with('user')->get();
        foreach ($karyawansToUpdate as $karyawan) {
            if ($karyawan->user && $karyawan->nama !== $karyawan->user->name) {
                $karyawan->nama = $karyawan->user->name;
                $karyawan->save();
            }
        }
        
        // 5. Tambahkan unique constraint ke user_id di tabel karyawan
        Schema::table('karyawan', function ($table) {
            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('karyawan', function ($table) {
            $table->dropUnique(['user_id']);
        });
    }
};
