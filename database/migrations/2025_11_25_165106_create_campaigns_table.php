<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained('organizations')->onDelete('restrict');
            $table->string('title');
            $table->text('description');
            $table->string('banner_url', 500)->nullable();
            $table->string('province', 100);
            $table->string('city', 100);
            $table->integer('target_quantity');
            $table->integer('collected_quantity')->default(0);
            $table->date('deadline');
            $table->enum('status', ['aktif', 'selesai'])->default('aktif');
            $table->integer('view_count')->default(0);
            $table->timestamps();
            
            $table->index('organization_id');
            $table->index('status');
            $table->index(['view_count', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};