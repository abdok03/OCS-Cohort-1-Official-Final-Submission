<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // We use raw SQL because modifying ENUMs with Eloquent can be tricky depending on DBAL
        DB::statement("ALTER TABLE bookings MODIFY COLUMN status ENUM('pending', 'approved', 'rejected', 'cancelled', 'confirmed', 'approved_by_admin', 'rejected_by_admin') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE bookings MODIFY COLUMN status ENUM('pending', 'approved', 'rejected', 'cancelled') NOT NULL DEFAULT 'pending'");
    }
};
