@extends('admin.user.app')

@section('title', 'Cari Produk - TokoKu')

@section('styles')
<style>
    /* Header & Filter */
    .search-container { padding: 16px; background: white; position: sticky; top: 0; z-index: 100; border-bottom: 1px solid #f0f0f0; }
    .search-box { background: #f5f5f5; border-radius: 12px; padding: 10px 16px; display: flex; align-items: center; gap: 10px; }
    .search-box input { border: none; background: transparent; outline: none; width: 100%; font-size: 14px; }

    .filter-section { padding: 12px 16px; overflow-x: auto; display: flex; gap: 8px; white-space: nowrap; background: white; border-bottom: 1px solid #f0f0f0; }
    .filter-section::-webkit-scrollbar { display: none; }
    .filter-chip { padding: 6px 16px; border-radius: 20px; border: 1px solid #ddd; font-size: 12px; text-decoration: none; color: #666; transition: 0.3s; }
    .filter-chip.active { background: #FF6B35; color: white; border-color: #FF6B35; }

    .hasil-info { padding: 16px; font-size: 13px; color: #888; }

    /* Grid Produk */
    .produk-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; padding: 0 16px 80px; } /* padding bawah buat nav-menu */

    /* Card Produk (Disesuaikan agar rapi) */
    .produk-card { background: white; border-radius: 12px; overflow: hidden; text-decoration: none; border: 1px solid #eee; display: flex; flex-direction: column; }
    .produk-img-wrap { width: 100%; height: 150px; background: #f9f9f9; display: flex; align-items: center; justify-content: center; font-size: 50px; overflow: hidden; position: relative; }
    .produk-img-wrap img { width: 100%; height: 100%; object-fit: cover; }
    .wish-btn { position: absolute; right: 8px; top: 8px; width: 30px; height: 30px; border-radius: 50%; border: none; display: flex; align-items: center; justify-content: center; font-size: 14px; cursor: pointer; background: rgba(255,255,255,0.9); color: #ff5a5f; }
    .wish-btn.active { background: #ffebee; color: #e53935; }
    .wish-btn.is-animating { animation: wishPop 0.22s ease; }
    @keyframes wishPop {
        0% { transform: scale(1); }
        50% { transform: scale(1.28); }
        100% { transform: scale(1); }
    }

    .produk-info { padding: 10px; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between; }
    .produk-nama { font-size: 13px; color: #333; font-weight: 500; margin-bottom: 4px; line-height: 1.3; height: 34px; overflow: hidden; }
    .produk-harga { font-size: 15px; font-weight: 800; color: #FF6B35; margin-bottom: 4px; }
    .produk-meta { font-size: 11px; color: #aaa; }
</style>
@endsection

@section('content')
<div class="search-container">
    <form action="{{ route('user.pencarian') }}" method="GET">
        <div class="search-box">
            <span>🔍</span>
            {{-- Menggunakan name="cari" sesuai permintaanmu --}}
            <input type="text" name="cari" placeholder="Cari barang impianmu..." value="{{ request('cari') }}">
        </div>
    </form>
</div>

<div class="filter-section">
    <a href="{{ route('user.pencarian') }}" class="filter-chip {{ !request('kategori') ? 'active' : '' }}">Semua</a>
    @foreach($allKategori as $kat)
        <a href="{{ route('user.pencarian', ['kategori' => $kat, 'cari' => request('cari')]) }}"
           class="filter-chip {{ request('kategori') == $kat ? 'active' : '' }}">
            {{ $kat }}
        </a>
    @endforeach
</div>

<div class="hasil-info">
    @if(request('cari'))
        Hasil pencarian untuk "<strong>{{ request('cari') }}</strong>"
    @else
        Menampilkan semua produk
    @endif
</div>

<div class="produk-grid">
    @forelse($produk as $p)
        <a href="{{ route('user.produk.detail', $p->ProdukID) }}" class="produk-card">
            <div class="produk-img-wrap">
                @if($p->foto && file_exists(public_path('storage/' . $p->foto)))
                    <img src="{{ asset('storage/' . $p->foto) }}" alt="{{ $p->NamaProduk }}">
                @else
                    📦
                @endif

                @php $isWish = in_array((int)$p->ProdukID, $wishlistProdukIds ?? [], true); @endphp
                @if(Session::has('pelanggan_id'))
                    <form action="{{ route('user.wishlist.toggle', $p->ProdukID) }}" method="POST" onsubmit="event.stopPropagation();" class="js-wishlist-form" style="position:absolute;right:8px;top:8px;z-index:3;">
                        @csrf
                        <button type="submit" class="wish-btn js-wishlist-btn {{ $isWish ? 'active' : '' }}" onclick="event.stopPropagation();" title="Wishlist">
                            {{ $isWish ? '♥' : '♡' }}
                        </button>
                    </form>
                @else
                    <a href="{{ route('user.login') }}" class="wish-btn" onclick="event.stopPropagation();" title="Login untuk wishlist" style="text-decoration:none;z-index:3;">♡</a>
                @endif
            </div>
            <div class="produk-info">
                <div>
                    <div class="produk-nama">{{ Str::limit($p->NamaProduk, 35) }}</div>
                    <div class="produk-harga">Rp {{ number_format($p->Harga, 0, ',', '.') }}</div>
                </div>
                <div class="produk-meta">Stok {{ $p->Stok }}</div>
            </div>
        </a>
    @empty
        <div class="kosong" style="grid-column: span 2; text-align: center; padding: 50px 0;">
            <div style="font-size: 60px;">🔍❌</div>
            <p style="color: #888; margin-top: 10px;">Duh, produknya nggak ketemu...</p>
            <a href="{{ route('user.pencarian') }}" style="color: #FF6B35; font-size: 14px; text-decoration: none; font-weight: bold;">Lihat Semua Produk</a>
        </div>
    @endforelse
</div>
@endsection
