<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lomba_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama');
            $table->text('deskripsi');
            $table->string('kategori');
            $table->string('penyelenggara')->nullable();
            $table->date('deadline')->nullable();
            $table->string('link_daftar')->nullable();
            $table->string('target')->nullable();
            $table->boolean('gratis')->default(true);
            $table->text('persyaratan')->nullable();
            $table->text('timeline')->nullable();
            $table->string('foto_poster')->nullable();
            $table->string('catatan')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('alasan_tolak')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lomba_requests');
    }
};