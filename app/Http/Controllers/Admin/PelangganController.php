<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PelangganController extends Controller
{
    // Ini fungsi utama untuk nampilin daftar user di halaman Admin
    public function index() {
        // Ambil data pelanggan, urutkan dari yang terbaru daftar
        $pelanggan = DB::table('pelanggan')
            ->where('role', 'user')
            ->orderBy('PelangganID', 'desc')
            ->get(); // Pakai get() dulu biar gampang, kalau data udah ribuan baru pakai paginate()

        return view('admin.pelanggan.index', compact('pelanggan'));
    }

    // Fungsi kalau Admin mau nambahin user manual dari dashboard
    public function store(Request $request) {
        DB::table('pelanggan')->insert([
            'NamaPelanggan' => $request->NamaPelanggan,
            'email' => $request->email,
            'NomorTelepon' => $request->NomorTelepon,
            'password' => Hash::make($request->password ?? 'password123'), // Password default kalau gak diisi
            'role' => 'user',
            'created_at' => now()
        ]);

        return redirect()->route('admin.pelanggan')->with('success', 'User berhasil ditambah!');
    }

    // Fungsi kalau Admin mau hapus user yang nakal
    public function destroy($id) {
        DB::table('pelanggan')->where('PelangganID', $id)->delete();
        return back()->with('success', 'User berhasil dihapus!');
    }
}
