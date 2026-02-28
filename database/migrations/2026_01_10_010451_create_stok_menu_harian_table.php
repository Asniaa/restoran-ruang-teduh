<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stok_menu_harian', function (Blueprint $table) {
            $table->id();

            $table->foreignId('operational_day_id')
                  ->constrained('operational_days')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            $table->foreignId('menu_id')
                  ->constrained('menu')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            $table->integer('stok');
            $table->timestamps();

            $table->unique(['operational_day_id', 'menu_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stok_menu_harian');
    }
};

