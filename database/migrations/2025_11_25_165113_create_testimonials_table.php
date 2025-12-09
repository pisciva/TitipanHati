<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['donatur', 'yayasan']);
            $table->text('content');
            $table->integer('rating')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('profile_picture')->nullable();
            $table->timestamps();
            
            $table->index('is_active');
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
