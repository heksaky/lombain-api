<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PremiumRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\NotifikasiController;

class PremiumRequestController extends Controller
{
    // User kirim request premium
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'no_hp'        => 'required|string|max:20',
            'bukti_bayar'  => 'required|image|max:3048',
        ]);

        // Cek apakah user sudah premium
        if ($request->user()->is_premium) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Kamu sudah menjadi member premium!',
            ], 400);
        }

        // Cek apakah sudah ada request pending
        $existing = PremiumRequest::where('user_id', $request->user()->id)
            ->where('status', 'pending')
            ->first();

        if ($existing) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Kamu sudah memiliki request premium yang sedang diproses.',
            ], 400);
        }

        $path = $request->file('bukti_bayar')->store('bukti-bayar', 'public');

        $premiumRequest = PremiumRequest::create([
            'user_id'      => $request->user()->id,
            'nama_lengkap' => $request->nama_lengkap,
            'no_hp'        => $request->no_hp,
            'bukti_bayar'  => $path,
            'status'       => 'pending',
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Request premium berhasil dikirim! Admin akan memverifikasi pembayaran kamu.',
            'data'    => $premiumRequest,
        ], 201);
    }

    // User cek status request miliknya
    public function statusSaya(Request $request)
    {
        $latest = PremiumRequest::where('user_id', $request->user()->id)
            ->latest()
            ->first();

        return response()->json([
            'status'     => 'success',
            'is_premium' => $request->user()->is_premium,
            'request'    => $latest,
        ]);
    }

    // Admin: lihat semua request premium
    public function adminIndex()
    {
        $requests = PremiumRequest::with('user')
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'data'   => $requests,
        ]);
    }

    // Admin: approve → user jadi premium
    public function approve(Request $request, $id)
    {
        $premiumRequest = PremiumRequest::findOrFail($id);

        if ($premiumRequest->status !== 'pending') {
            return response()->json([
                'status'  => 'error',
                'message' => 'Request sudah diproses sebelumnya.',
            ], 400);
        }

        $premiumRequest->update(['status' => 'approved']);

        \App\Models\User::where('id', $premiumRequest->user_id)
            ->update(['is_premium' => true]);

        return response()->json([
            'status'  => 'success',
            'message' => 'User berhasil dijadikan member premium!',
        ]);
    }

    // Admin: tolak request
    public function reject(Request $request, $id)
    {
        $premiumRequest = PremiumRequest::findOrFail($id);

        if ($premiumRequest->status !== 'pending') {
            return response()->json([
                'status'  => 'error',
                'message' => 'Request sudah diproses sebelumnya.',
            ], 400);
        }

        $premiumRequest->update([
            'status'      => 'rejected',
            'alasan_tolak' => $request->alasan ?? 'Bukti pembayaran tidak valid',
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Request premium ditolak.',
        ]);
    }
}