<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lomba;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Ambil semua lomba
    public function index()
    {
        $lombas = Lomba::latest()->get();
        return response()->json([
            'status' => 'success',
            'data'   => $lombas,
        ]);
    }

    // Tambah lomba baru
    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori'  => 'required|string',
            'singkatan' => 'required|string|max:20',
            'gratis'    => 'required|boolean',
        ]);

        $lomba = Lomba::create([
            'nama'          => $request->nama,
            'deskripsi'     => $request->deskripsi,
            'kategori'      => $request->kategori,
            'singkatan'     => $request->singkatan,
            'warna'         => $request->warna ?? '#EEF2FF',
            'teks_warna'    => $request->teks_warna ?? '#4A2F9E',
            'gratis'        => $request->gratis,
            'penyelenggara' => $request->penyelenggara,
            'deadline'      => $request->deadline,
            'link_daftar'   => $request->link_daftar,
            'target'        => $request->target,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Lomba berhasil ditambahkan',
            'data'    => $lomba,
        ], 201);
    }

    // Update lomba
    public function update(Request $request, $id)
    {
        $lomba = Lomba::findOrFail($id);

        $request->validate([
            'nama'      => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori'  => 'required|string',
            'singkatan' => 'required|string|max:20',
            'gratis'    => 'required|boolean',
        ]);

        $lomba->update([
            'nama'          => $request->nama,
            'deskripsi'     => $request->deskripsi,
            'kategori'      => $request->kategori,
            'singkatan'     => $request->singkatan,
            'warna'         => $request->warna ?? $lomba->warna,
            'teks_warna'    => $request->teks_warna ?? $lomba->teks_warna,
            'gratis'        => $request->gratis,
            'penyelenggara' => $request->penyelenggara,
            'deadline'      => $request->deadline,
            'link_daftar'   => $request->link_daftar,
            'target'        => $request->target,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Lomba berhasil diupdate',
            'data'    => $lomba,
        ]);
    }

    // Hapus lomba
    public function destroy($id)
    {
        $lomba = Lomba::findOrFail($id);
        $lomba->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Lomba berhasil dihapus',
        ]);
    }
}