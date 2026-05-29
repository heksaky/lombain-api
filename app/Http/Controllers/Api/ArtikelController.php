<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    // Ambil semua artikel
    public function index()
    {
        return response()->json([
            'data' => Artikel::latest()->get()
        ]);
    }

    // Ambil detail artikel
    public function show($id)
    {
        $artikel = Artikel::findOrFail($id);

        return response()->json([
            'data' => $artikel
        ]);
    }

    // Tambah artikel
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'ringkasan' => 'required',
            'konten' => 'required',
            'kategori' => 'required',
            'penulis' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $fotoPath = null;

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('artikel', 'public');
        }

        $artikel = Artikel::create([
            'judul' => $request->judul,
            'ringkasan' => $request->ringkasan,
            'konten' => $request->konten,
            'kategori' => $request->kategori,
            'penulis' => $request->penulis,
            'foto' => $fotoPath,
        ]);

        return response()->json([
            'message' => 'Artikel berhasil ditambahkan',
            'data' => $artikel
        ]);
    }
}