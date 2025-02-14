<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class MasterSekolahController extends Controller
{
    // Menampilkan semua data sekolah yang tidak dihapus
    public function index()
    {
        try {
            $sekolah = DB::table('master_sekolah')->where('is_delete', 0)->get();
            return response()->json([
                'success' => true,
                'message' => 'Data sekolah berhasil diambil',
                'data' => $sekolah
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data sekolah',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Menampilkan detail sekolah berdasarkan ID
    public function show($id)
    {
        try {
            $sekolah = DB::table('master_sekolah')->where('id', $id)->where('is_delete', 0)->first();

            if (!$sekolah) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data sekolah ditemukan',
                'data' => $sekolah
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data sekolah',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Menambahkan data sekolah baru
    public function store(Request $request)
    {
        try {
            $id = DB::table('master_sekolah')->insertGetId([
                'kode_prop' => $request->kode_prop,
                'propinsi' => $request->propinsi,
                'kode_kab_kota' => $request->kode_kab_kota,
                'kabupaten_kota' => $request->kabupaten_kota,
                'kode_kec' => $request->kode_kec,
                'kecamatan' => $request->kecamatan,
                'npsn' => $request->npsn,
                'sekolah' => $request->sekolah,
                'bentuk' => $request->bentuk,
                'status' => $request->status,
                'alamat_jalan' => $request->alamat_jalan,
                'lintang' => $request->lintang,
                'bujur' => $request->bujur,
                'is_delete' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $newData = DB::table('master_sekolah')->where('id', $id)->first();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil ditambahkan',
                'data' => $newData
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan data sekolah',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Soft delete data sekolah
    public function destroy($id)
    {
        try {
            $affected = DB::table('master_sekolah')->where('id', $id)->update(['is_delete' => 1, 'updated_at' => now()]);

            if (!$affected) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan atau sudah dihapus'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data sekolah',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
