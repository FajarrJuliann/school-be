<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterSekolahController extends Controller
{
    // Menampilkan semua data sekolah
    public function index()
    {
        $sekolah = DB::table('master_sekolah')->get();
        return response()->json($sekolah);
    }

    // Menampilkan detail sekolah berdasarkan ID
    public function show($id)
    {
        $sekolah = DB::table('master_sekolah')->where('id', $id)->first();
        if (!$sekolah) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
        return response()->json($sekolah);
    }

    // Menambahkan data sekolah baru
    public function store(Request $request)
    {
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
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Data berhasil ditambahkan', 'id' => $id], 201);
    }

    public function update(Request $request, $id)
{
    // Ambil hanya input yang dikirim dalam request
    $dataToUpdate = array_filter($request->only([
        'kode_prop',
        'propinsi',
        'kode_kab_kota',
        'kabupaten_kota',
        'kode_kec',
        'kecamatan',
        'npsn',
        'sekolah',
        'bentuk',
        'status',
        'alamat_jalan',
        'lintang',
        'bujur'
    ]));

    // Tambahkan updated_at agar tetap diperbarui
    $dataToUpdate['updated_at'] = now();

    // Jika tidak ada data yang dikirim, kembalikan response error
    if (empty($dataToUpdate)) {
        return response()->json(['message' => 'Tidak ada data yang diperbarui'], 400);
    }

    // Update hanya field yang diberikan
    $affected = DB::table('master_sekolah')->where('id', $id)->update($dataToUpdate);

    if (!$affected) {
        return response()->json(['message' => 'Data tidak ditemukan atau tidak ada perubahan'], 404);
    }

    return response()->json(['message' => 'Data berhasil diperbarui']);
}

    

    // Menghapus data sekolah berdasarkan ID
    public function destroy($id)
    {
        $deleted = DB::table('master_sekolah')->where('id', $id)->delete();

        if (!$deleted) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
