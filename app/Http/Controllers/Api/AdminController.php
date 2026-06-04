<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lomba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $lombas = Lomba::latest()->get();
        return response()->json(['status' => 'success', 'data' => $lombas]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'        => 'required|string|max:255',
            'deskripsi'   => 'required|string',
            'kategori'    => 'required|string',
            'singkatan'   => 'nullable|string|max:20',
            'gratis'      => 'required',
            'foto_poster' => 'nullable|image|max:2048',
        ]);

        $data = [
            'nama'          => $request->nama,
            'deskripsi'     => $request->deskripsi,
            'kategori'      => $request->kategori,
            'singkatan'     => $request->singkatan ?? '',
            'warna'         => $request->warna ?? '#EEF2FF',
            'teks_warna'    => $request->teks_warna ?? '#4A2F9E',
            'gratis'        => filter_var($request->gratis, FILTER_VALIDATE_BOOLEAN),
            'penyelenggara' => $request->penyelenggara,
            'deadline'      => $request->deadline ?: null,
            'link_daftar'   => $request->link_daftar,
            'target'        => $request->target,
            'persyaratan'   => $request->persyaratan,
            'timeline'      => $request->timeline,
        ];

        if ($request->hasFile('foto_poster')) {
            $path = $request->file('foto_poster')->store('posters', 'public');
            $data['foto_poster'] = $path;
        }

        $lomba = Lomba::create($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Lomba berhasil ditambahkan',
            'data'    => $lomba,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $lomba = Lomba::findOrFail($id);

        \Log::info('UPDATE REQUEST', [
            'has_file' => $request->hasFile('foto_poster'),
            'all_keys' => array_keys($request->all()),
            'files'    => array_keys($request->allFiles()),
        ]);

        $request->validate([
            'nama'        => 'required|string|max:255',
            'deskripsi'   => 'required|string',
            'kategori'    => 'required|string',
            'singkatan'   => 'nullable|string|max:20',
            'gratis'      => 'required',
            'foto_poster' => 'nullable|image|max:2048',
        ]);

        $data = [
            'nama'          => $request->nama,
            'deskripsi'     => $request->deskripsi,
            'kategori'      => $request->kategori,
            'singkatan'     => $request->singkatan ?? $lomba->singkatan,
            'warna'         => $request->warna ?? $lomba->warna,
            'teks_warna'    => $request->teks_warna ?? $lomba->teks_warna,
            'gratis'        => filter_var($request->gratis, FILTER_VALIDATE_BOOLEAN),
            'penyelenggara' => $request->penyelenggara,
            'deadline'      => $request->deadline ?: null,
            'link_daftar'   => $request->link_daftar,
            'target'        => $request->target,
            'persyaratan'   => $request->persyaratan,
            'timeline'      => $request->timeline,
        ];

        if ($request->hasFile('foto_poster')) {
            if ($lomba->foto_poster) {
                Storage::disk('public')->delete($lomba->foto_poster);
            }
            $path = $request->file('foto_poster')->store('posters', 'public');
            $data['foto_poster'] = $path;
        }

        $lomba->update($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Lomba berhasil diupdate',
            'data'    => $lomba->fresh(),
        ]);
    }

    public function destroy($id)
    {
        $lomba = Lomba::findOrFail($id);

        if ($lomba->foto_poster) {
            Storage::disk('public')->delete($lomba->foto_poster);
        }

        $lomba->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Lomba berhasil dihapus',
        ]);
    }
}