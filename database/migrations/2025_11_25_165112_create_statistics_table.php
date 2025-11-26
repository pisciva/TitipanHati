<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('statistics', function (Blueprint $table) {
            $table->id();
            $table->integer('total_campaigns')->default(0);
            $table->integer('total_donations')->default(0);
            $table->integer('total_items_collected')->default(0);
            $table->integer('total_organizations')->default(0);
            $table->date('recorded_date')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('statistics');
    }
};