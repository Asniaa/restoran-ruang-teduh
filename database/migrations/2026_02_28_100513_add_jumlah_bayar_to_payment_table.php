<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payment', function (Blueprint $table) {
            $table->decimal('jumlah_bayar', 10, 2)->after('total_bayar');
            $table->decimal('kembalian', 10, 2)->after('jumlah_bayar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment', function (Blueprint $table) {
            $table->dropColumn(['jumlah_bayar', 'kembalian']);
        });
    }
};
