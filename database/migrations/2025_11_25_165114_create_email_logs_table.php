<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donation_id')->nullable()->constrained('donations')->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('email_to');
            $table->enum('email_type', ['konfirmasi_donasi', 'reset_password', 'verifikasi_email']);
            $table->text('email_content');
            $table->boolean('is_sent')->default(false);
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
            
            $table->index('donation_id');
            $table->index('user_id');
            $table->index('email_type');
            $table->index('is_sent');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_logs');
    }
};