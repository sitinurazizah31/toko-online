@extends('admin.user.app')

@section('title', 'Beranda - TokoKu')

@section('styles')
<style>
    /* Style tetap sama seperti punyamu karena sudah bagus */
    .banner { margin: 12px 16px; border-radius: 14px; background: #FF6B35; padding: 20px 24px; color: white; position: relative; overflow: hidden; }
    .banner-bg { position: absolute; right: 16px; top: 50%; transform: translateY(-50%); font-size: 70px; opacity: 0.15; }
    .banner-title { font-size: 18px; font-weight: 800; margin-bottom: 4px; }
    .banner-sub { font-size: 12px; opacity: 0.9; margin-bottom: 14px; }
    .banner-btn { background: white; color: #FF6B35; border: none; padding: 8px 18px; border-radius: 20px; font-size: 12px; font-weight: 700; cursor: pointer; text-decoration: none; display: inline-block; }
    .section { padding: 12px 16px; }
    .section-title { font-size: 14px; font-weight: 700; color: #1a1f2e; margin-bottom: 12px; display: flex; justify-content: space-between; align-items: center; }
    .section-title a { font-size: 12px; color: #FF6B35; font-weight: 600; text-decoration: none; }
    .kategori-scroll { display: flex; gap: 12px; overflow-x: auto; padding-bottom: 4px; }
    .kategori-scroll::-webkit-scrollbar { display: none; }
    .kat-item { display: flex; flex-direction: column; align-items: center; gap: 6px; flex-shrink: 0; text-decoration: none; }
    .kat-icon { width: 56px; height: 56px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 26px; }
    .kat-label { font-size: 11px; color: #555; font-weight: 500; }
    .promo-row { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; padding: 0 16px; margin-bottom: 8px; }
    .promo-card { border-radius: 12px; padding: 14px; color: white; position: relative; overflow: hidden; }
    .promo-card.merah { background: #ef4444; }
    .promo-card.biru { background: #3b82f6; }
    .promo-emoji { position: absolute; right: 8px; top: 8px; font-size: 30px; opacity: 0.25; }
    .promo-judul { font-size: 13px; font-weight: 700; margin-bottom: 2px; }
    .promo-sub { font-size: 10px; opacity: 0.85; }
    .produk-section { padding: 12px 16px 18px; }
    .produk-head { display: flex; justify-content: space-between; align-items: end; margin-bottom: 12px; }
    .produk-title-wrap { display: flex; flex-direction: column; }
    .produk-title { font-size: 16px; font-weight: 800; color: #13223c; line-height: 1.2; }
    .produk-subtitle { font-size: 11px; color: #6b7280; margin-top: 2px; }
    .produk-link-all { font-size: 12px; font-weight: 700; color: #FF6B35; text-decoration: none; }
    .produk-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; }
    .produk-card {
        background: linear-gradient(180deg, #ffffff 0%, #fff9f6 100%);
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid #ffe5d9;
        box-shadow: 0 10px 24px rgba(255, 107, 53, 0.08);
        animation: cardEnter 0.35s ease forwards;
        opacity: 0;
        transform: translateY(6px);
        animation-delay: calc(var(--i, 0) * 0.04s);
    }
    @keyframes cardEnter {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .produk-card:hover { transform: translateY(-3px); box-shadow: 0 14px 28px rgba(255, 107, 53, 0.12); }
    .produk-img-wrap {
        width: 100%;
        height: 150px;
        background: radial-gradient(circle at 20% 20%, #fff 0%, #fff6f1 60%, #ffe7db 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 50px;
        position: relative;
        overflow: hidden;
    }
    .produk-detail-hit { position: absolute; inset: 0; z-index: 1; }
    .produk-img-wrap img { width: 100%; height: 100%; object-fit: cover; }
    .produk-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: #FF6B35;
        color: white;
        font-size: 10px;
        font-weight: 700;
        padding: 3px 9px;
        border-radius: 20px;
        z-index: 2;
        box-shadow: 0 4px 10px rgba(255, 107, 53, 0.35);
    }
    .wish-btn { position: absolute; right: 8px; top: 8px; width: 30px; height: 30px; border-radius: 50%; border: none; display: flex; align-items: center; justify-content: center; font-size: 14px; cursor: pointer; background: rgba(255,255,255,0.9); color: #ff5a5f; }
    .wish-btn.active { background: #ffebee; color: #e53935; }
    .wish-btn.is-animating { animation: wishPop 0.22s ease; }
    @keyframes wishPop {
        0% { transform: scale(1); }
        50% { transform: scale(1.28); }
        100% { transform: scale(1); }
    }
    .produk-info { padding: 10px; }
    .produk-nama {
        font-size: 13px;
        color: #273244;
        margin-bottom: 5px;
        font-weight: 700;
        line-height: 1.35;
        text-decoration: none;
        display: block;
    }
    .produk-harga { font-size: 16px; font-weight: 900; color: #FF6B35; margin-bottom: 8px; letter-spacing: 0.2px; }
    .produk-meta-row { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 9px; }
    .produk-chip {
        font-size: 10px;
        font-weight: 700;
        border-radius: 999px;
        padding: 4px 8px;
        color: #344054;
        background: #f6f8fb;
        border: 1px solid #e7ecf4;
    }
    .produk-actions { display: grid; grid-template-columns: 1fr 1.2fr; gap: 8px; }
    .detail-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        border: 1px solid #ffd5c5;
        color: #FF6B35;
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
        background: #fff;
    }
    .keranjang-btn {
        width: 100%;
        background: linear-gradient(135deg, #ff7f50, #ff5c1c);
        color: white;
        border: none;
        padding: 8px;
        border-radius: 10px;
        cursor: pointer;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.2px;
    }
    .kosong { text-align: center; padding: 40px; color: #aaa; font-size: 14px; grid-column: span 2; }

    @media (max-width: 430px) {
        .produk-actions { grid-template-columns: 1fr; }
        .detail-btn, .keranjang-btn { padding: 9px 8px; }
    }
</style>
@endsection

@section('content')

{{-- BANNER --}}
<div class="banner">
    <div class="banner-bg">🛍️</div>
    <div class="banner-title">Selamat Datang! 👋</div>
    <div class="banner-sub">Temukan produk terbaik dengan harga terjangkau</div>
    <a href="{{ route('user.pencarian') }}" class="banner-btn">Belanja Sekarang</a>
</div>

{{-- KATEGORI --}}
<div class="section">
    <div class="section-title">
        Kategori
        <a href="{{ route('user.pencarian') }}">Lihat Semua</a>
    </div>
    <div class="kategori-scroll">
        @php
            $ikonKat = [
                'Pakaian'    => ['icon' => '👔', 'bg' => '#fff0eb'],
                'Sepatu'     => ['icon' => '👟', 'bg' => '#eff6ff'],
                'Tas'        => ['icon' => '🎒', 'bg' => '#f0fdf4'],
                'Aksesoris'  => ['icon' => '⌚', 'bg' => '#faf5ff'],
                'Elektronik' => ['icon' => '📱', 'bg' => '#fff0f6'],
                'Lainnya'    => ['icon' => '📦', 'bg' => '#f8f8f8'],
            ];
        @endphp
        @forelse($kategori as $kat)
        @php $info = $ikonKat[$kat] ?? ['icon' => '📦', 'bg' => '#f8f8f8']; @endphp
        <a href="{{ route('user.pencarian', ['kategori' => $kat]) }}" class="kat-item">
            <div class="kat-icon" style="background-color: {{ $info['bg'] }};">
                {{ $info['icon'] }}
            </div>
            <div class="kat-label">{{ $kat }}</div>
        </a>
        @empty
        <p style="color:#aaa;font-size:13px">Belum ada kategori</p>
        @endforelse
    </div>
</div>

{{-- PROMO --}}
<div class="promo-row">
    <div class="promo-card merah">
        <div class="promo-emoji">🔥</div>
        <div class="promo-judul">Flash Sale</div>
        <div class="promo-sub">Diskon spesial hari ini</div>
    </div>
    <div class="promo-card biru">
        <div class="promo-emoji">🚚</div>
        <div class="promo-judul">Gratis Ongkir</div>
        <div class="promo-sub">Min. belanja Rp50rb</div>
    </div>
</div>

{{-- PRODUK TERBARU --}}
<div class="produk-section">
    <div class="produk-head">
        <div class="produk-title-wrap">
            <div class="produk-title">Produk Terbaru</div>
            <div class="produk-subtitle">Pilihan favorit dengan kualitas terbaik</div>
        </div>
        <a href="{{ route('user.pencarian') }}" class="produk-link-all">Lihat Semua</a>
    </div>

<div class="produk-grid">
    @forelse($produkTerbaru as $p)
    {{-- FIX: Gunakan ProdukID (Huruf P, I, dan D Besar!) --}}
    <article class="produk-card" style="--i: {{ $loop->index }};">
        <div class="produk-img-wrap">
            <a href="{{ route('user.produk.detail', $p->ProdukID) }}" class="produk-detail-hit" aria-label="Lihat detail {{ $p->NamaProduk }}"></a>
            {{-- FIX: Gunakan foto (sesuai phpMyAdmin kamu) --}}
            @if($p->foto && file_exists(public_path('storage/' . $p->foto)))
                <img src="{{ asset('storage/' . $p->foto) }}" alt="{{ $p->NamaProduk }}">
            @else
                <div style="font-size: 50px;">📦</div>
            @endif

            @if(($p->total_terjual ?? 0) > 50)
                <div class="produk-badge">HOT</div>
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
            <a href="{{ route('user.produk.detail', $p->ProdukID) }}" class="produk-nama">{{ Str::limit($p->NamaProduk, 36) }}</a>
            <div class="produk-harga">Rp {{ number_format($p->Harga, 0, ',', '.') }}</div>

            <div class="produk-meta-row">
                <div class="produk-chip">Terjual {{ $p->total_terjual ?? 0 }}</div>
                <div class="produk-chip">Stok {{ $p->Stok ?? 0 }}</div>
            </div>

            <div class="produk-actions">
                <a href="{{ route('user.produk.detail', $p->ProdukID) }}" class="detail-btn">Lihat Detail</a>
                <form action="{{ route('user.keranjang.tambah', $p->ProdukID) }}" method="POST">
                    @csrf
                    <button type="submit" class="keranjang-btn">+ Keranjang</button>
                </form>
            </div>
        </div>
    </article>
    @empty
    <div class="kosong">Belum ada produk tersedia</div>
    @endforelse
</div>
</div>

@endsection
