<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lombas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('deskripsi');
            $table->string('kategori');
            $table->string('singkatan', 20);
            $table->string('warna', 20)->default('#EEF');
            $table->string('teks_warna', 20)->default('#333');
            $table->boolean('gratis')->default(true);
            $table->string('penyelenggara')->nullable();
            $table->date('deadline')->nullable();
            $table->string('link_daftar')->nullable();
            $table->string('target')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lombas');
    }
};