<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(config('laravolt.indonesia.table_prefix').'provinces', function (Blueprint $table) {
            $table->id();
            $table->char('code', 2)->unique()->comment('Kode provinsi sesuai standar ISO atau Laravolt');
            $table->string('name', 255)->comment('Nama provinsi');
            $table->json('meta')->nullable()->comment('Data tambahan (lat, long, dsb)');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(config('laravolt.indonesia.table_prefix').'provinces');
    }
};
