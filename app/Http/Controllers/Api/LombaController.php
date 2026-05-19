<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lomba;
use Illuminate\Http\Request;

class LombaController extends Controller
{
    // Ambil semua lomba
    public function index(Request $request)
    {
        $query = Lomba::query();

        // Filter kategori
        if ($request->kategori && $request->kategori !== 'semua') {
            $query->where('kategori', $request->kategori);
        }

        // Search
        if ($request->search) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $lombas = $query->latest()->get();

        return response()->json([
            'status' => 'success',
            'data'   => $lombas,
        ]);
    }

    // Ambil detail lomba
    public function show($id)
    {
        $lomba = Lomba::findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data'   => $lomba,
        ]);
    }
}