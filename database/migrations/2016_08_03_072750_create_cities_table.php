<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(config('laravolt.indonesia.table_prefix').'cities', function (Blueprint $table) {
            $table->id();
            $table->char('code', 4)->unique();
            $table->char('province_code', 2);
            $table->string('name', 255);
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->foreign('province_code')
                  ->references('code')
                  ->on(config('laravolt.indonesia.table_prefix').'provinces')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(config('laravolt.indonesia.table_prefix').'cities');
    }
};
