<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\Notifikasi;
use App\Models\Lomba;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function index(Request $request)
    {
        $bookmarks = Bookmark::where('user_id', $request->user()->id)
            ->with('lomba')
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'data'   => $bookmarks->pluck('lomba'),
        ]);
    }

    public function toggle(Request $request, $lomba_id)
    {
        $user = $request->user();

        $bookmark = Bookmark::where('user_id', $user->id)
            ->where('lomba_id', $lomba_id)
            ->first();

        if ($bookmark) {
            $bookmark->delete();
            return response()->json([
                'status'     => 'success',
                'bookmarked' => false,
                'message'    => 'Bookmark dihapus',
            ]);
        } else {
            Bookmark::create([
                'user_id'  => $user->id,
                'lomba_id' => $lomba_id,
            ]);

            // Buat notifikasi deadline jika lomba punya deadline
            $lomba = Lomba::find($lomba_id);
            if ($lomba && $lomba->deadline) {
                $tanggal = \Carbon\Carbon::parse($lomba->deadline)
                    ->locale('id')
                    ->translatedFormat('d F Y');

                Notifikasi::create([
                    'user_id' => $user->id,
                    'judul'   => '⏰ Deadline: ' . $lomba->nama,
                    'pesan'   => 'Lomba "' . $lomba->nama . '" yang kamu bookmark memiliki deadline pada ' . $tanggal . '. Cek jadwalnya di Kalender!',
                    'tipe'    => 'deadline',
                    'dibaca'  => false,
                ]);
            }

            return response()->json([
                'status'     => 'success',
                'bookmarked' => true,
                'message'    => 'Bookmark ditambahkan',
            ]);
        }
    }

    public function check(Request $request, $lomba_id)
    {
        $bookmarked = Bookmark::where('user_id', $request->user()->id)
            ->where('lomba_id', $lomba_id)
            ->exists();

        return response()->json([
            'status'     => 'success',
            'bookmarked' => $bookmarked,
        ]);
    }
}