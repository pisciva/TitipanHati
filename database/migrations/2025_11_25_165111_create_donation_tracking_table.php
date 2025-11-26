<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donation_tracking', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donation_id')->constrained('donations')->onDelete('cascade');
            $table->enum('status', ['menunggu_penjemputan', 'dalam_perjalanan', 'selesai', 'dibatalkan']);
            $table->text('notes')->nullable();
            $table->timestamp('status_changed_at')->useCurrent();
            
            $table->index('donation_id');
            $table->index('status_changed_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donation_tracking');
    }
};