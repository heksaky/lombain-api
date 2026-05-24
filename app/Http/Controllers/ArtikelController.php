<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    public function index(Request $request)
    {
        $query = Artikel::latest();
        if ($request->kategori) {
            $query->where('kategori', $request->kategori);
        }
        return response()->json(['data' => $query->get()]);
    }

    public function show($id)
    {
        $artikel = Artikel::findOrFail($id);
        return response()->json(['data' => $artikel]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'     => 'required|string',
            'ringkasan' => 'nullable|string',
            'konten'    => 'required|string',
            'kategori'  => 'nullable|string',
            'penulis'   => 'nullable|string',
            'foto'      => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('artikels', 'public');
        }

        return response()->json(['data' => Artikel::create($data)], 201);
    }

    public function update(Request $request, $id)
    {
        $artikel = Artikel::findOrFail($id);
        $data = $request->validate([
            'judul'     => 'sometimes|string',
            'ringkasan' => 'nullable|string',
            'konten'    => 'sometimes|string',
            'kategori'  => 'nullable|string',
            'penulis'   => 'nullable|string',
            'foto'      => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('artikels', 'public');
        }

        $artikel->update($data);
        return response()->json(['data' => $artikel]);
    }

    public function destroy($id)
    {
        Artikel::findOrFail($id)->delete();
        return response()->json(['message' => 'Artikel berhasil dihapus']);
    }
}