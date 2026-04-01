<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class KeranjangController extends Controller
{
    public function index()
    {
        $pelangganId = Session::get('pelanggan_id');

        // Cek jika belum login, lempar ke halaman login
        if (!$pelangganId) {
            return redirect()->route('user.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data keranjang join dengan tabel produk
        $keranjang = DB::table('keranjang')
            ->join('produk', 'keranjang.ProdukID', '=', 'produk.ProdukID')
            ->where('keranjang.PelangganID', $pelangganId)
            ->select('keranjang.*', 'produk.NamaProduk', 'produk.Harga', 'produk.foto')
            ->get();

        // Hitung total harga otomatis
        $totalHarga = $keranjang->sum(function($item) {
            return $item->Harga * $item->jumlah;
        });

        // SESUAIKAN JALUR VIEW: karena user di dalam admin
        return view('admin.user.keranjang', compact('keranjang', 'totalHarga'));
    }

    public function tambah(Request $request, $id)
{
    // Cek apakah user sudah login melalui session
    if (!session()->has('pelanggan_id')) {
        return redirect()->route('user.login')->with('error', 'Login dulu yuk!');
    }

    $pelangganId = session()->get('pelanggan_id');

    // Cek apakah barang sudah ada di keranjang untuk user ini
    $item = DB::table('keranjang')
        ->where('PelangganID', $pelangganId)
        ->where('ProdukID', $id)
        ->first();

    if ($item) {
        // Jika sudah ada, tambah jumlahnya saja
        DB::table('keranjang')->where('KeranjangID', $item->KeranjangID)->increment('jumlah', 1);
    } else {
        // Jika belum ada, buat baris baru di tabel keranjang
        DB::table('keranjang')->insert([
            'PelangganID' => $pelangganId,
            'ProdukID'    => $id,
            'jumlah'      => 1,
            'created_at'  => now()
        ]);
    }

    return redirect()->route('user.keranjang')->with('success', 'Barang berhasil masuk keranjang! 🛒');
}

    public function hapus($id)
    {
        DB::table('keranjang')->where('KeranjangID', $id)->delete();
        return back()->with('success', 'Produk dihapus dari keranjang!');
    }

    public function checkout(Request $request)
    {
        $pelangganId = Session::get('pelanggan_id');

        if (!$pelangganId) {
            return redirect()->route('user.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $request->validate([
            'metode' => 'required|in:Transfer,COD,E-Wallet',
        ]);

        $metodePembayaran = $request->metode;

        $items = DB::table('keranjang')
            ->join('produk', 'keranjang.ProdukID', '=', 'produk.ProdukID')
            ->where('keranjang.PelangganID', $pelangganId)
            ->select('keranjang.KeranjangID', 'keranjang.jumlah', 'produk.Harga')
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('user.keranjang')->with('error', 'Keranjang masih kosong, tidak bisa checkout.');
        }

        $totalHarga = $items->sum(function ($item) {
            return $item->Harga * $item->jumlah;
        });

        DB::transaction(function () use ($pelangganId, $items, $totalHarga, $metodePembayaran) {
            $penjualanId = DB::table('penjualan')->insertGetId([
                'PelangganID' => $pelangganId,
                'TanggalPenjualan' => now()->toDateString(),
                'TotalHarga' => $totalHarga,
                'status_pembayaran' => 'belum_bayar',
                'status_pesanan' => 'diproses',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $namaPelanggan = DB::table('pelanggan')
                ->where('PelangganID', $pelangganId)
                ->value('NamaPelanggan') ?? 'Pelanggan';

            // Otomatis buat data pembayaran sesuai metode yang dipilih user.
            DB::table('pembayaran')->insert([
                'penjualan_id' => $penjualanId,
                'nama' => $namaPelanggan,
                'metode' => $metodePembayaran,
                'total' => $totalHarga,
                'status' => 'menunggu',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('keranjang')->where('PelangganID', $pelangganId)->delete();
        });

        return redirect()
            ->route('user.pesanan', ['status' => 'belum_bayar'])
            ->with('success', 'Checkout berhasil! Metode pembayaran: ' . $metodePembayaran . '. Pesanan masuk ke riwayat belum bayar.');
    }
}
