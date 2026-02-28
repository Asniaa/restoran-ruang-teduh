<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pesanan_id')
                  ->constrained('pesanan')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            $table->foreignId('karyawan_id')
                  ->constrained('karyawan')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            $table->enum('metode_pembayaran', ['cash', 'qris']);
            $table->decimal('total_bayar', 10, 2);
            $table->dateTime('waktu_bayar')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment');
    }
};
