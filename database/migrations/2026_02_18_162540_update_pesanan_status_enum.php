<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Alter enum column to include new statuses
        DB::statement("ALTER TABLE pesanan MODIFY COLUMN status ENUM('open', 'preparing', 'ready', 'paid', 'cancelled') DEFAULT 'open'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original statuses
        DB::statement("ALTER TABLE pesanan MODIFY COLUMN status ENUM('open', 'paid', 'cancelled') DEFAULT 'open'");
    }
};
