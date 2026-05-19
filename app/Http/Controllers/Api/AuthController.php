<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status'  => 'success',
            'message' => 'Registrasi berhasil',
            'token'   => $token,
            'user'    => $user,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Email atau password salah',
            ], 401);
        }

        $user  = Auth::user()->fresh();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'token'  => $token,
            'user'   => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Logout berhasil',
        ]);
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }
    // Update profil
public function updateProfile(Request $request)
{
    $user = $request->user();

    $request->validate([
        'name'    => 'required|string|max:255',
        'jenjang' => 'nullable|in:SMA Kelas 10,SMA Kelas 11,SMA Kelas 12,Mahasiswa',
    ]);

    $user->update([
        'name'    => $request->name,
        'jenjang' => $request->jenjang,
    ]);

    return response()->json([
        'status'  => 'success',
        'message' => 'Profil berhasil diupdate',
        'user'    => $user,
    ]);
}

// Ganti password
public function updatePassword(Request $request)
{
    $request->validate([
        'password_lama' => 'required',
        'password'      => 'required|min:6|confirmed',
    ]);

    $user = $request->user();

    if (!\Illuminate\Support\Facades\Hash::check($request->password_lama, $user->password)) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Password lama tidak sesuai',
        ], 400);
    }

    $user->update([
        'password' => \Illuminate\Support\Facades\Hash::make($request->password),
    ]);

    return response()->json([
        'status'  => 'success',
        'message' => 'Password berhasil diubah',
    ]);
}
}