<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void
    {
        Schema::create('meja', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_meja', 10);
            $table->enum('status', ['available', 'booked', 'occupied'])->default('available');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meja');
    }
};