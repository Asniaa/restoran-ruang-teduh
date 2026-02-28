<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE pesanan MODIFY COLUMN status ENUM('open', 'preparing', 'ready', 'delivered', 'paid', 'cancelled') NOT NULL DEFAULT 'open'");
    }

    public function down(): void
    {
        // Revert to original list if possible, but data might be lost if we have new statuses.
        // For now, we can just keep it or revert to a safe subset if needed.
        // DB::statement("ALTER TABLE pesanan MODIFY COLUMN status ENUM('open', 'paid', 'cancelled') NOT NULL DEFAULT 'open'");
    }
};
