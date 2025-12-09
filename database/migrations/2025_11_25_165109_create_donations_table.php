<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('campaign_id')->constrained('campaigns')->onDelete('restrict');
            $table->string('donor_name');
            $table->string('donor_phone', 20);
            $table->string('donor_email');
            $table->text('pickup_address');
            $table->string('pickup_province', 100);
            $table->string('pickup_city', 100);
            $table->string('pickup_district', 100);
            $table->string('pickup_postal_code', 10);
            $table->text('pickup_notes')->nullable();
            $table->date('pickup_date');
            $table->enum('pickup_time_slot', ['09:00-13:00', '13:00-17:00']);
            $table->enum('status', ['menunggu_penjemputan', 'dalam_perjalanan', 'selesai', 'dibatalkan'])->default('menunggu_penjemputan');
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('campaign_id');
            $table->index('status');
            $table->index('pickup_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};