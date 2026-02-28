<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();

            $table->foreignId('operational_day_id')
                  ->constrained('operational_days')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            $table->foreignId('meja_id')
                  ->nullable()
                  ->constrained('meja')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();

            $table->enum('jenis_pesanan', ['dine_in', 'take_away']);
            $table->enum('status', ['open', 'paid', 'cancelled'])->default('open');

            $table->foreignId('ditangani_oleh')
                  ->constrained('karyawan')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            $table->dateTime('waktu_pesan')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};