<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LombaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('lombas')->insert([
            [
                'nama'         => 'Olimpiade Sains Nasional',
                'deskripsi'    => 'Kompetisi sains tahunan bergengsi di Indonesia untuk siswa SD, SMP, dan SMA, diselenggarakan oleh Puspresnas Kemendikbudristek.',
                'kategori'     => 'sains',
                'singkatan'    => 'OSN',
                'warna'        => '#EEEEFF',
                'teks_warna'   => '#E74C3C',
                'gratis'       => true,
                'penyelenggara'=> 'Puspresnas Kemendikbudristek',
                'deadline'     => '2026-06-30',
                'link_daftar'  => 'https://pusatprestasinasional.kemdikbud.go.id',
                'target'       => 'SMA',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'nama'         => 'Festival Lomba Seni Siswa Nasional',
                'deskripsi'    => 'Ajang kompetisi seni dan sastra bergengsi tingkat nasional bagi siswa Indonesia, diselenggarakan oleh Pusat Prestasi Nasional.',
                'kategori'     => 'seni',
                'singkatan'    => 'FLS3N',
                'warna'        => '#FFF5E6',
                'teks_warna'   => '#E67E22',
                'gratis'       => true,
                'penyelenggara'=> 'Pusat Prestasi Nasional',
                'deadline'     => '2026-07-15',
                'link_daftar'  => 'https://pusatprestasinasional.kemdikbud.go.id',
                'target'       => 'SMA',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'nama'         => 'Olimpiade Olahraga Siswa Nasional',
                'deskripsi'    => 'Kompetisi olahraga tahunan bergengsi bagi siswa SD, SMA, dan Pendidikan Khusus untuk menjaring bibit atlet berbakat.',
                'kategori'     => 'olahraga',
                'singkatan'    => 'O2SN',
                'warna'        => '#E8F5E9',
                'teks_warna'   => '#27AE60',
                'gratis'       => true,
                'penyelenggara'=> 'Pusat Prestasi Nasional',
                'deadline'     => '2026-08-01',
                'link_daftar'  => 'https://pusatprestasinasional.kemdikbud.go.id',
                'target'       => 'SMA',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'nama'         => 'Hackathon Nasional 2026',
                'deskripsi'    => 'Kompetisi pemrograman 48 jam untuk mahasiswa seluruh Indonesia. Bangun solusi inovatif berbasis teknologi.',
                'kategori'     => 'teknologi',
                'singkatan'    => '</>',
                'warna'        => '#EEF2FF',
                'teks_warna'   => '#4A2F9E',
                'gratis'       => true,
                'penyelenggara'=> 'Kemenkominfo',
                'deadline'     => '2026-09-01',
                'link_daftar'  => 'https://hackathon.kominfo.go.id',
                'target'       => 'Mahasiswa',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'nama'         => 'National Business Plan Competition',
                'deskripsi'    => 'Kompetisi rencana bisnis tingkat nasional bagi mahasiswa. Presentasikan ide bisnis terbaikmu di hadapan juri profesional.',
                'kategori'     => 'bisnis',
                'singkatan'    => 'NBPC',
                'warna'        => '#FFF9E6',
                'teks_warna'   => '#D4880D',
                'gratis'       => false,
                'penyelenggara'=> 'Universitas Indonesia',
                'deadline'     => '2026-08-15',
                'link_daftar'  => 'https://nbpc.ui.ac.id',
                'target'       => 'Mahasiswa',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);
    }
}