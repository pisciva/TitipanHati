<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->string('full_name');
            $table->string('phone_number', 20);
            $table->text('default_address')->nullable();
            $table->string('default_city', 100)->nullable();
            $table->string('default_district', 100)->nullable();
            $table->string('default_postal_code', 10)->nullable();
            $table->text('default_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
