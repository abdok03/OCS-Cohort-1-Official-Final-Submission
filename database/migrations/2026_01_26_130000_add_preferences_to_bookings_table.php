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
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('hospitality_package')->nullable()->after('special_requests')->comment('cake, kunafa, none');
            $table->string('flower_color')->nullable()->after('hospitality_package')->comment('red, yellow, white, none');
            $table->boolean('is_mixed')->default(false)->after('flower_color')->comment('Is the event mixed gender?');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['hospitality_package', 'flower_color', 'is_mixed']);
        });
    }
};
