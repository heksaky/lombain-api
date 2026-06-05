<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LombaRequest;
use App\Models\Lomba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LombaRequestController extends Controller
{
    // User kirim request lomba baru
    public function store(Request $request)
    {
        $request->validate([
            'nama'        => 'required|string|max:255',
            'deskripsi'   => 'required|string',
            'kategori'    => 'required|string',
            'gratis'      => 'required',
            'foto_poster' => 'nullable|image|max:3048',
        ]);

        $data = [
            'user_id'       => $request->user()->id,
            'nama'          => $request->nama,
            'deskripsi'     => $request->deskripsi,
            'kategori'      => $request->kategori,
            'penyelenggara' => $request->penyelenggara,
            'deadline'      => $request->deadline ?: null,
            'link_daftar'   => $request->link_daftar,
            'target'        => $request->target,
            'gratis'        => filter_var($request->gratis, FILTER_VALIDATE_BOOLEAN),
            'persyaratan'   => $request->persyaratan,
            'timeline'      => $request->timeline,
            'catatan'       => $request->catatan,
            'status'        => 'pending',
        ];

        if ($request->hasFile('foto_poster')) {
            $path = $request->file('foto_poster')->store('lomba-requests', 'public');
            $data['foto_poster'] = $path;
        }

        $lombaRequest = LombaRequest::create($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Request lomba berhasil dikirim! Admin akan meninjaunya.',
            'data'    => $lombaRequest,
        ], 201);
    }

    // User lihat riwayat request miliknya
    public function milikSaya(Request $request)
    {
        $requests = LombaRequest::where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'data'   => $requests,
        ]);
    }

    // Admin: lihat semua request
    public function adminIndex()
    {
        $requests = LombaRequest::with('user')
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'data'   => $requests,
        ]);
    }

    // Admin: approve request → otomatis tambah ke tabel lombas
    public function approve(Request $request, $id)
    {
        $lombaRequest = LombaRequest::findOrFail($id);

        if ($lombaRequest->status !== 'pending') {
            return response()->json([
                'status'  => 'error',
                'message' => 'Request sudah diproses sebelumnya',
            ], 400);
        }

        // Tambahkan ke tabel lombas
        Lomba::create([
            'nama'          => $lombaRequest->nama,
            'deskripsi'     => $lombaRequest->deskripsi,
            'kategori'      => $lombaRequest->kategori,
            'singkatan'     => strtoupper(substr($lombaRequest->nama, 0, 4)),
            'warna'         => '#EEF2FF',
            'teks_warna'    => '#4A2F9E',
            'gratis'        => $lombaRequest->gratis,
            'penyelenggara' => $lombaRequest->penyelenggara,
            'deadline'      => $lombaRequest->deadline,
            'link_daftar'   => $lombaRequest->link_daftar,
            'target'        => $lombaRequest->target,
            'persyaratan'   => $lombaRequest->persyaratan,
            'timeline'      => $lombaRequest->timeline,
            'foto_poster'   => $lombaRequest->foto_poster,
        ]);

        $lombaRequest->update(['status' => 'approved']);

        return response()->json([
            'status'  => 'success',
            'message' => 'Request disetujui dan lomba telah dipublikasikan!',
        ]);
    }

    // Admin: tolak request
    public function reject(Request $request, $id)
    {
        $lombaRequest = LombaRequest::findOrFail($id);

        if ($lombaRequest->status !== 'pending') {
            return response()->json([
                'status'  => 'error',
                'message' => 'Request sudah diproses sebelumnya',
            ], 400);
        }

        $lombaRequest->update([
            'status'      => 'rejected',
            'alasan_tolak' => $request->alasan ?? 'Tidak memenuhi kriteria',
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Request telah ditolak.',
        ]);
    }
}