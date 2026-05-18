<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    // Ambil semua bookmark user
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

    // Toggle bookmark (tambah/hapus)
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
            return response()->json([
                'status'     => 'success',
                'bookmarked' => true,
                'message'    => 'Bookmark ditambahkan',
            ]);
        }
    }

    // Cek apakah lomba sudah dibookmark
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