<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['donatur', 'admin'])->default('donatur');
            $table->string('google_id')->nullable()->unique();
            $table->boolean('is_verified')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            
            $table->index('email');
            $table->index('google_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};