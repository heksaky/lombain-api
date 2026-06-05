<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    // Ambil semua notifikasi user
    public function index(Request $request)
    {
        $notifikasis = Notifikasi::where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return response()->json([
            'status'       => 'success',
            'data'         => $notifikasis,
            'belum_dibaca' => $notifikasis->where('dibaca', false)->count(),
        ]);
    }

    // Tandai satu notifikasi sebagai dibaca
    public function baca(Request $request, $id)
    {
        Notifikasi::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->update(['dibaca' => true]);

        return response()->json(['status' => 'success']);
    }

    // Tandai semua notifikasi sebagai dibaca
    public function bacaSemua(Request $request)
    {
        Notifikasi::where('user_id', $request->user()->id)
            ->update(['dibaca' => true]);

        return response()->json(['status' => 'success']);
    }
}