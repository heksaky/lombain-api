<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('premium_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama_lengkap');
            $table->string('no_hp');
            $table->string('bukti_bayar');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('alasan_tolak')->nullable();
            $table->timestamps();
        });

        // Tambah kolom is_premium ke tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_premium')->default(false)->after('role');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('premium_requests');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_premium');
        });
    }
};