<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detail_pesanan', function (Blueprint $table) {
            // rename qty -> kuantitas
            if (Schema::hasColumn('detail_pesanan', 'qty')) {
                $table->renameColumn('qty', 'kuantitas');
            }
        });
    }

    public function down(): void
    {
        Schema::table('detail_pesanan', function (Blueprint $table) {
            // rollback kuantitas -> qty
            if (Schema::hasColumn('detail_pesanan', 'kuantitas')) {
                $table->renameColumn('kuantitas', 'qty');
            }
        });
    }
};
