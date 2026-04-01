<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB; // Tambahkan ini agar bisa akses database
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\User\BerandaController;
use App\Http\Controllers\User\PencarianController;
use App\Http\Controllers\User\KeranjangController;
use App\Http\Controllers\User\WishlistController;

// ============================================================
// BERANDA PUBLIK (Halaman Utama)
// ============================================================
Route::get('/', [BerandaController::class, 'index'])->name('/');

// ============================================================
// AUTH USER & ADMIN
// ============================================================
Route::get('/login',         [AuthController::class, 'showLoginUser'])->name('user.login');
Route::post('/login',        [AuthController::class, 'loginUser'])->name('user.login.post');
Route::get('/register',      [AuthController::class, 'showRegister'])->name('register');
Route::post('/register',     [AuthController::class, 'register'])->name('register.post');
Route::post('/logout',       [AuthController::class, 'logout'])->name('logout');

Route::get('/admin/login',   [AuthController::class, 'showLoginAdmin'])->name('admin.login');
Route::post('/admin/login',  [AuthController::class, 'loginAdmin'])->name('admin.login.post');

// ============================================================
// ADMIN PANEL
// ============================================================
Route::prefix('admin')->name('admin.')->middleware('auth.admin')->group(function () {

    // Core Features
    Route::get('/dashboard',         [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/produk',            [ProdukController::class, 'index'])->name('produk');
    Route::post('/produk',           [ProdukController::class, 'store'])->name('produk.store');
    Route::put('/produk/{id}',       [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}',    [ProdukController::class, 'destroy'])->name('produk.destroy');

    Route::get('/pesanan',           [PesananController::class, 'index'])->name('pesanan');
    Route::put('/pesanan/{id}',      [PesananController::class, 'update'])->name('pesanan.update');

    Route::get('/pelanggan',         [PelangganController::class, 'index'])->name('pelanggan');
    Route::get('/pelanggan/create',  [PelangganController::class, 'create'])->name('pelanggan.create');
    Route::post('/pelanggan',        [PelangganController::class, 'store'])->name('pelanggan.store');
    Route::delete('/pelanggan/{id}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy');

    // --- ROUTE PEMBAYARAN ---
    Route::get('/pembayaran', function () {
        $pembayaran = DB::table('pembayaran')->get();
        return view('admin.pembayaran.index', compact('pembayaran'));
    })->name('pembayaran');

    // INI YANG TADI BIKIN ERROR (Route Update Pembayaran)
    Route::put('/pembayaran/{id}', function (Illuminate\Http\Request $request, $id) {
        DB::table('pembayaran')->where('id', $id)->update([
            'status' => $request->status,
            'updated_at' => now(),
        ]);

        $pembayaran = DB::table('pembayaran')->where('id', $id)->first();
        if ($pembayaran && !empty($pembayaran->penjualan_id)) {
            $statusPenjualan = strtolower($request->status) === 'berhasil' ? 'sudah_bayar' : 'belum_bayar';

            DB::table('penjualan')
                ->where('PenjualanID', $pembayaran->penjualan_id)
                ->update([
                    'status_pembayaran' => $statusPenjualan,
                    'updated_at' => now(),
                ]);
        }

        return back()->with('success', 'Status pembayaran berhasil diperbarui!');
    })->name('pembayaran.update');

    // --- ROUTE PENGIRIMAN ---
    Route::get('/pengiriman', function () {
        $pengiriman = DB::table('pengiriman')->get();
        return view('admin.pengiriman.index', compact('pengiriman'));
    })->name('pengiriman');

    // Tambahkan Update Pengiriman juga biar gak error nanti
    Route::put('/pengiriman/{id}', function (Illuminate\Http\Request $request, $id) {
        DB::table('pengiriman')->where('id', $id)->update([
            'status' => $request->status,
        ]);
        return back()->with('success', 'Status pengiriman diperbarui!');
    })->name('pengiriman.update');

    // --- ROUTE LAPORAN (VERSI LENGKAP) ---
    Route::get('/laporan', function () {
        // 1. Ambil data untuk tabel Pembayaran (dipakai di baris 24 Blade)
        $pembayaran = DB::table('pembayaran')->get();

        // 2. Ambil data untuk tabel Pengiriman (dipakai di baris 60 Blade)
        $pengiriman = DB::table('pengiriman')->get();

        // Kirim kedua variabel tersebut ke view
        return view('admin.laporan.index', compact('pembayaran', 'pengiriman'));
    })->name('laporan');

    // Route tambahan Sidebar (Arahkan ke view kosong dulu agar tidak error)
    Route::get('/promo',      fn() => view('admin.promo.index', ['promo' => []]))->name('promo');
    Route::get('/chat',       fn() => view('admin.chat.index'))->name('chat');
    Route::get('/pengaturan', fn() => view('admin.pengaturan.index'))->name('pengaturan');
});

// ============================================================
// USER AREA
// ============================================================
Route::prefix('user')->name('user.')->group(function () {
    Route::get('/beranda',     [BerandaController::class, 'index'])->name('beranda');
    Route::get('/pencarian',   [PencarianController::class, 'index'])->name('pencarian');
    Route::get('/produk/{id}', [PencarianController::class, 'detail'])->name('produk.detail');

    Route::middleware('auth.user')->group(function () {
        Route::get('/keranjang',              [KeranjangController::class, 'index'])->name('keranjang');
        Route::post('/keranjang/tambah/{id}', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
        Route::delete('/keranjang/hapus/{id}',[KeranjangController::class, 'hapus'])->name('keranjang.hapus');
        Route::post('/keranjang/checkout',    [KeranjangController::class, 'checkout'])->name('keranjang.checkout');

        Route::get('/wishlist',               [WishlistController::class, 'index'])->name('wishlist');
        Route::post('/wishlist/toggle/{id}',  [WishlistController::class, 'toggle'])->name('wishlist.toggle');

        Route::get('/profil',                 [AuthController::class, 'profil'])->name('profil');
        Route::post('/profil/update',         [AuthController::class, 'updateProfil'])->name('profil.update');
        Route::get('/pesanan',                [AuthController::class, 'pesananSaya'])->name('pesanan');
        Route::get('/pengaturan',             [AuthController::class, 'pengaturanAkun'])->name('pengaturan');
        Route::post('/pengaturan/update',     [AuthController::class, 'updatePengaturanAkun'])->name('pengaturan.update');
    });
});
