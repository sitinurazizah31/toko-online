<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    // ============================================================
    // TAMPIL DAFTAR PRODUK
    // ============================================================
    public function index(Request $request)
    {
        $query = DB::table('produk');

        // Filter pencarian
        if ($request->search) {
            $query->where('NamaProduk', 'like', '%' . $request->search . '%');
        }

        // Filter kategori
        if ($request->kategori) {
            $query->where('kategori', $request->kategori);
        }

        // Filter stok
        if ($request->stok === 'habis') {
            $query->where('Stok', 0);
        } elseif ($request->stok === 'menipis') {
            $query->whereBetween('Stok', [1, 10]);
        } elseif ($request->stok === 'aman') {
            $query->where('Stok', '>', 10);
        }

        $produk = $query->orderBy('created_at', 'desc')->paginate(10);
        $kategori = DB::table('produk')->distinct()->pluck('kategori')->filter();

        return view('admin.produk.index', compact('produk', 'kategori'));
    }

    // ============================================================
    // SIMPAN PRODUK BARU
    // ============================================================
public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'NamaProduk' => 'required',
        'Harga' => 'required|numeric',
        'Stok' => 'required|integer',
        'kategori' => 'required',
        'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Simpan file foto ke folder: storage/app/public/produk
    $namaFoto = time() . '.' . $request->foto->extension();
    $request->foto->storeAs('produk', $namaFoto, 'public');

    // Insert ke tabel produk
    DB::table('produk')->insert([
        'NamaProduk' => $request->NamaProduk,
        'Harga'      => $request->Harga,
        'Stok'       => $request->Stok,
        'deskripsi'  => $request->deskripsi,
        'kategori'   => $request->kategori,
        'foto'       => $namaFoto, // Ini yang bakal ngisi kolom 'foto' yang tadinya NULL
        'rating'     => 0,
        'total_terjual' => 0,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('admin.produk')->with('success', 'Produk Berhasil Ditambah!');
}
    // ============================================================
    // UPDATE PRODUK
    // ============================================================
    public function update(Request $request, $id)
    {
        $request->validate([
            'NamaProduk' => 'required|string|max:255',
            'Harga'      => 'required|numeric|min:0',
            'Stok'       => 'required|integer|min:0',
            'kategori'   => 'required|string|max:100',
            'deskripsi'  => 'nullable|string',
            'foto'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $produk = DB::table('produk')->where('ProdukID', $id)->first();
        if (!$produk) {
            return redirect()->route('admin.produk')->with('error', 'Produk tidak ditemukan.');
        }

        $fotoPath = $produk->foto;
        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }
            $fotoPath = $request->file('foto')->store('produk', 'public');
        }

        DB::table('produk')->where('ProdukID', $id)->update([
            'NamaProduk' => $request->NamaProduk,
            'Harga'      => $request->Harga,
            'Stok'       => $request->Stok,
            'kategori'   => $request->kategori,
            'deskripsi'  => $request->deskripsi,
            'foto'       => $fotoPath,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.produk')->with('success', 'Produk berhasil diperbarui!');
    }

    // ============================================================
    // HAPUS PRODUK
    // ============================================================
    public function destroy($id)
    {
        $produk = DB::table('produk')->where('ProdukID', $id)->first();
        if (!$produk) {
            return redirect()->route('admin.produk')->with('error', 'Produk tidak ditemukan.');
        }

        // Hapus foto
        if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
            Storage::disk('public')->delete($produk->foto);
        }

        DB::table('produk')->where('ProdukID', $id)->delete();

        return redirect()->route('admin.produk')->with('success', 'Produk berhasil dihapus!');
    }
}
