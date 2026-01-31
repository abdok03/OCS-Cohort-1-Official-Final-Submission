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
        Schema::create('halls', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('capacity_min');
            $table->integer('capacity_max');
            $table->decimal('price_per_day', 10, 2);
            $table->decimal('price_per_hour', 10, 2);
            $table->string('address');
            $table->string('city');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('halls');
    }
};
