<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('operational_days')) {
            Schema::create('operational_days', function (Blueprint $table) {
                $table->id();
                $table->date('tanggal')->unique();
                $table->enum('status', ['buka', 'tutup'])->default('buka');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operational_days');
    }
};
