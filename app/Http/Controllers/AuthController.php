<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // ============================================================
    // LOGIN & REGISTER USER (PELANGGAN)
    // ============================================================
    public function showRegister() {
        if (Session::has('admin_id') && Session::get('role') === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        if (Session::has('pelanggan_id') && Session::get('role') === 'user') {
            return redirect()->route('user.beranda');
        }

        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'NamaPelanggan' => 'required|string|max:255',
            'NomorTelepon' => 'required|string|max:20',
            'Alamat' => 'nullable|string',
            'email' => 'required|email|max:255|unique:pelanggan,email',
            'password' => 'required|string|min:8|confirmed',
            'agree' => 'accepted',
        ]);

        DB::table('pelanggan')->insert([
            'NamaPelanggan' => $request->NamaPelanggan,
            'NomorTelepon' => $request->NomorTelepon,
            'Alamat' => $request->Alamat,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('user.login')->with('success', 'Registrasi berhasil. Silakan login.');
    }

    public function showLoginUser() {
        if (Session::has('admin_id') && Session::get('role') === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        if (Session::has('pelanggan_id') && Session::get('role') === 'user') {
            return redirect()->route('user.beranda');
        }
        return view('auth.login-user');
    }

    public function loginUser(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $account = DB::table('pelanggan')
            ->where('email', $request->email)
            ->first();

        if (!$account || !Hash::check($request->password, $account->password)) {
            return back()->withErrors(['Email atau kata sandi salah.'])->withInput();
        }

        if ($account->role === 'admin') {
            Session::put('admin_id', $account->PelangganID);
            Session::put('nama_petugas', $account->NamaPelanggan);
            Session::put('role', 'admin');

            return redirect()->route('admin.dashboard')->with('success', 'Halo Admin!');
        }

        Session::put('pelanggan_id',   $account->PelangganID);
        Session::put('nama_pelanggan', $account->NamaPelanggan);
        Session::put('role',           'user');

        return redirect()->route('user.beranda')->with('success', 'Selamat datang!');
    }

    // ============================================================
    // LOGIN ADMIN (MENGGUNAKAN TABEL PELANGGAN)
    // ============================================================
    public function showLoginAdmin() {
        // Jika sudah login sebagai admin, langsung lempar ke dashboard
        if (Session::has('admin_id') && Session::get('role') === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.login-admin');
    }

    public function loginAdmin(Request $request) {
        $request->validate([
            'email'    => 'required|email', // Admin pakai email karena di tabel pelanggan
            'password' => 'required'
        ]);

        // Cari di tabel pelanggan yang role-nya 'admin'
        $admin = DB::table('pelanggan')
                    ->where('email', $request->email)
                    ->where('role', 'admin')
                    ->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            // Set session Admin
            Session::put('admin_id',     $admin->PelangganID);
            Session::put('nama_petugas',  $admin->NamaPelanggan);
            Session::put('role',          'admin');

            return redirect()->route('admin.dashboard')->with('success', 'Halo Admin!');
        }

        return back()->withErrors(['error' => 'Email atau Password Admin salah!'])->withInput();
    }

    // ============================================================
    // LOGOUT (OTOMATIS DETEKSI ROLE)
    // ============================================================
    public function logout() {
        $role = Session::get('role');
        Session::flush();

        if ($role === 'admin') {
            return redirect()->route('admin.login');
        }
        return redirect()->route('/');
    }

    // ============================================================
    // PROFIL USER
    // ============================================================
    public function profil() {
        $pelangganId = Session::get('pelanggan_id');
        if (!$pelangganId) return redirect()->route('user.login');

        $pelanggan = DB::table('pelanggan')->where('PelangganID', $pelangganId)->first();
        return view('admin.user.profil', compact('pelanggan'));
    }

    public function pesananSaya(Request $request) {
        $pelangganId = Session::get('pelanggan_id');
        if (!$pelangganId) {
            return redirect()->route('user.login');
        }

        $status = $request->get('status');

        $query = DB::table('penjualan')
            ->where('PelangganID', $pelangganId)
            ->orderBy('created_at', 'desc');

        if ($status === 'belum_bayar') {
            $query->where('status_pembayaran', 'belum_bayar');
        }

        $pesanan = $query->paginate(10)->withQueryString();

        return view('admin.user.pesanan', compact('pesanan', 'status'));
    }

    public function pengaturanAkun() {
        $pelangganId = Session::get('pelanggan_id');
        if (!$pelangganId) {
            return redirect()->route('user.login');
        }

        $pelanggan = DB::table('pelanggan')->where('PelangganID', $pelangganId)->first();
        return view('admin.user.pengaturan', compact('pelanggan'));
    }

    public function updatePengaturanAkun(Request $request) {
        $pelangganId = Session::get('pelanggan_id');
        if (!$pelangganId) {
            return redirect()->route('user.login');
        }

        $request->validate([
            'NamaPelanggan' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:pelanggan,email,' . $pelangganId . ',PelangganID',
            'NomorTelepon' => 'required|string|max:20',
            'Alamat' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'NamaPelanggan' => $request->NamaPelanggan,
            'email' => $request->email,
            'NomorTelepon' => $request->NomorTelepon,
            'Alamat' => $request->Alamat,
            'updated_at' => now(),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        DB::table('pelanggan')->where('PelangganID', $pelangganId)->update($data);

        Session::put('nama_pelanggan', $request->NamaPelanggan);

        return redirect()->route('user.pengaturan')->with('success', 'Pengaturan akun berhasil diperbarui!');
    }

    public function updateProfil(Request $request) {
        $pelangganId = Session::get('pelanggan_id');
        $request->validate([
            'NamaPelanggan' => 'required|string|max:255',
            'NomorTelepon'  => 'required|string|max:15',
            'Alamat'        => 'nullable|string',
        ]);

        DB::table('pelanggan')->where('PelangganID', $pelangganId)->update([
            'NamaPelanggan' => $request->NamaPelanggan,
            'NomorTelepon'  => $request->NomorTelepon,
            'Alamat'        => $request->Alamat,
            'updated_at'    => now(),
        ]);

        Session::put('nama_pelanggan', $request->NamaPelanggan);
        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}
