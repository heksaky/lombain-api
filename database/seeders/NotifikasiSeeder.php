<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotifikasiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('notifikasis')->insert([
            [
                'user_id'    => null, // global, untuk semua user
                'judul'      => '🎉 Lomba Baru Ditambahkan!',
                'pesan'      => 'Olimpiade Sains Nasional (OSN) 2026 sudah dibuka pendaftarannya. Jangan sampai ketinggalan!',
                'tipe'       => 'lomba_baru',
                'lomba_id'   => 1,
                'dibaca'     => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id'    => null,
                'judul'      => '⏰ Deadline Mendekat!',
                'pesan'      => 'Deadline pendaftaran FLS2N tinggal 7 hari lagi. Segera daftarkan dirimu!',
                'tipe'       => 'deadline',
                'lomba_id'   => 2,
                'dibaca'     => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id'    => null,
                'judul'      => '📢 Pengumuman',
                'pesan'      => 'Selamat datang di LombaIn! Platform informasi lomba terlengkap untuk pelajar dan mahasiswa Indonesia.',
                'tipe'       => 'pengumuman',
                'lomba_id'   => null,
                'dibaca'     => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id'    => null,
                'judul'      => '🏆 Lomba Baru: Hackathon Nasional',
                'pesan'      => 'Hackathon Nasional 2026 hadir untuk mahasiswa seluruh Indonesia. Hadiah total ratusan juta rupiah!',
                'tipe'       => 'lomba_baru',
                'lomba_id'   => 4,
                'dibaca'     => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}