<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(config('laravolt.indonesia.table_prefix').'districts', function (Blueprint $table) {
            $table->id();
            $table->char('code', 7)->unique();
            $table->char('city_code', 4);
            $table->string('name', 255);
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->foreign('city_code')
                  ->references('code')
                  ->on(config('laravolt.indonesia.table_prefix').'cities')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(config('laravolt.indonesia.table_prefix').'districts');
    }
};
