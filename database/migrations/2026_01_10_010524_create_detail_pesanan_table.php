<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pesanan_id')
                  ->constrained('pesanan')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            $table->foreignId('menu_id')
                  ->constrained('menu')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            $table->integer('qty');
            $table->text('catatan')->nullable();
            $table->decimal('harga_saat_pesan', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pesanan');
    }
};