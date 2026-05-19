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
        $notifikasis = Notifikasi::where(function($q) use ($request) {
                $q->where('user_id', $request->user()->id)
                  ->orWhereNull('user_id'); // notifikasi global
            })
            ->latest()
            ->get();

        $belumDibaca = $notifikasis->where('dibaca', false)->count();

        return response()->json([
            'status' => 'success',
            'data'   => $notifikasis,
            'belum_dibaca' => $belumDibaca,
        ]);
    }

    // Tandai semua sudah dibaca
    public function bacaSemua(Request $request)
    {
        Notifikasi::where(function($q) use ($request) {
                $q->where('user_id', $request->user()->id)
                  ->orWhereNull('user_id');
            })
            ->where('dibaca', false)
            ->update(['dibaca' => true]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Semua notifikasi sudah dibaca',
        ]);
    }

    // Tandai satu notifikasi sudah dibaca
    public function baca($id, Request $request)
    {
        $notif = Notifikasi::findOrFail($id);
        $notif->update(['dibaca' => true]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Notifikasi sudah dibaca',
        ]);
    }
}