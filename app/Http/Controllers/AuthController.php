<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\RefUser;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    // Register User
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:ref_users',
            'email' => 'required|email|unique:ref_users',
            'password' => 'required|min:8',
            'role' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 400);
        }

        $user = RefUser::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => md5($request->password), // MD5 untuk konsistensi
            'role' => $request->role,
            'is_login' => 0,
            'is_delete' => 0,
        ]);

        return response()->json(['success' => true, 'message' => 'User berhasil terdaftar'], 201);
    }

    // Login User dengan Sanctum
    public function login(Request $request)
    {
        $user = RefUser::where('email', $request->email)
            ->where('password', md5($request->password))
            ->where('is_delete', 0)
            ->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Email atau password salah'], 401);
        }

        // Buat token menggunakan Sanctum
        $token = $user->createToken('auth_token')->plainTextToken;

        // Update status login
        $user->update(['is_login' => 1]);

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'token' => $token,
            'user' => $user
        ]);
    }

    // Logout User
    public function logout(Request $request)
    {
        try {
            $user = $request->user();

            // Hapus hanya token yang sedang digunakan (bukan semua token)
            $user->currentAccessToken()->delete();

            // Set status is_login menjadi 0
            $user->update(['is_login' => 0]);

            return response()->json([
                'success' => true,
                'message' => 'Logout berhasil'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal logout',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    // Get Data User (Protected)
    public function getUser(Request $request)
    {
        return response()->json(['success' => true, 'user' => $request->user()]);
    }
}
