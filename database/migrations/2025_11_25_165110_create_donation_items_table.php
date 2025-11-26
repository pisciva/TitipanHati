<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donation_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donation_id')->constrained('donations')->onDelete('cascade');
            $table->enum('gender', ['Anak Laki-laki', 'Anak Perempuan', 'Laki-laki', 'Perempuan']);
            $table->enum('item_category', ['Atasan', 'Bawahan', 'Other']);
            $table->integer('quantity');
            $table->enum('condition', ['Baru', 'Layak pakai', 'Tidak layak']);
            $table->string('photo_url', 500)->nullable();
            $table->timestamps();
            
            $table->index('donation_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donation_items');
    }
};