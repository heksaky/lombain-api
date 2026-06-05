<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    public function index()
    {
        $artikels = Artikel::latest()->get();
        return response()->json([
            'status' => 'success',
            'data'   => $artikels,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'    => 'required|string|max:255',
            'konten'   => 'required',
            'kategori' => 'required|string',
        ]);

        $path = null;
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('artikels', 'public');
        }

        $artikel = Artikel::create([
            'judul'     => $request->judul,
            'ringkasan' => $request->ringkasan,
            'konten'    => $request->konten,
            'kategori'  => $request->kategori,
            'penulis'   => $request->penulis,
            'foto'      => $path,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Artikel berhasil ditambahkan!',
            'data'    => $artikel,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $artikel = Artikel::findOrFail($id);

        $request->validate([
            'judul'    => 'required|string|max:255',
            'konten'   => 'required',
            'kategori' => 'required|string',
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('artikels', 'public');
            $artikel->foto = $path;
        }

        $artikel->update([
            'judul'     => $request->judul,
            'ringkasan' => $request->ringkasan,
            'konten'    => $request->konten,
            'kategori'  => $request->kategori,
            'penulis'   => $request->penulis,
            'foto'      => $artikel->foto,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Artikel berhasil diupdate!',
            'data'    => $artikel,
        ]);
    }

    public function destroy($id)
    {
        $artikel = Artikel::findOrFail($id);
        $artikel->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Artikel berhasil dihapus!',
        ]);
    }

    public function show($id)
    {
        $artikel = Artikel::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data'   => $artikel,
        ]);
    }
}