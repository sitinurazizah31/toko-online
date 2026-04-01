@extends('admin.user.app')

@section('title', $produk->NamaProduk)

@section('styles')
<style>
    .detail-container {
        min-height: 100vh;
        background:
            radial-gradient(circle at 10% -10%, rgba(255, 107, 53, 0.18), transparent 42%),
            radial-gradient(circle at 90% 5%, rgba(255, 206, 140, 0.28), transparent 36%),
            #f7f8fb;
        padding: 14px 14px 108px;
    }
    .hero {
        background: #fff;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 14px 34px rgba(18, 22, 33, 0.1);
        border: 1px solid #f1f2f5;
        margin-bottom: 12px;
    }
    .img-wrap {
        position: relative;
        width: 100%;
        aspect-ratio: 1 / 1;
        background: linear-gradient(145deg, #fff8f4, #fff);
    }
    .main-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .img-empty {
        width: 100%;
        height: 100%;
        display: grid;
        place-items: center;
        font-size: 70px;
    }
    .btn-back {
        position: absolute;
        top: 12px;
        left: 12px;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: rgba(26, 31, 46, 0.72);
        color: #fff;
        text-decoration: none;
        display: grid;
        place-items: center;
        font-size: 17px;
        z-index: 2;
        backdrop-filter: blur(3px);
    }
    .badge-cat {
        position: absolute;
        right: 12px;
        top: 12px;
        background: rgba(255, 255, 255, 0.95);
        color: #1a1f2e;
        font-size: 11px;
        font-weight: 700;
        border-radius: 999px;
        padding: 5px 11px;
    }
    .hero-info {
        padding: 16px;
    }
    .price-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 8px;
    }
    .price {
        color: #ff6b35;
        font-size: 26px;
        font-weight: 800;
        letter-spacing: -0.01em;
    }
    .stock-chip {
        border-radius: 999px;
        padding: 6px 10px;
        font-size: 11px;
        font-weight: 700;
        color: #155724;
        background: #ecfdf3;
        border: 1px solid #bef3d1;
        white-space: nowrap;
    }
    .stock-chip.low {
        color: #9a3412;
        background: #fff7ed;
        border-color: #fed7aa;
    }
    .product-title {
        font-size: 20px;
        color: #1a1f2e;
        line-height: 1.35;
        margin-bottom: 10px;
    }
    .meta-row {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    .meta-pill {
        border-radius: 999px;
        font-size: 11px;
        color: #5a6377;
        background: #f4f6fb;
        border: 1px solid #e8ecf6;
        padding: 5px 10px;
        font-weight: 600;
    }
    .section-box {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #eef1f6;
        box-shadow: 0 8px 20px rgba(16, 24, 40, 0.05);
        padding: 14px;
        margin-bottom: 12px;
    }
    .section-title {
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #8a91a0;
        margin-bottom: 8px;
        font-weight: 700;
    }
    .desc-text {
        color: #424a5c;
        font-size: 14px;
        line-height: 1.7;
    }
    .recommend-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
    }
    .recommend-card {
        text-decoration: none;
        color: inherit;
        border: 1px solid #eceff4;
        border-radius: 12px;
        overflow: hidden;
        background: #fff;
        transition: transform 0.18s ease, box-shadow 0.18s ease;
    }
    .recommend-card:active {
        transform: translateY(1px) scale(0.995);
    }
    .recommend-img {
        width: 100%;
        height: 110px;
        object-fit: cover;
        background: #f5f7fb;
    }
    .recommend-info {
        padding: 8px;
    }
    .recommend-name {
        font-size: 12px;
        color: #2a3244;
        line-height: 1.35;
        min-height: 32px;
        margin-bottom: 4px;
    }
    .recommend-price {
        font-size: 13px;
        font-weight: 800;
        color: #ff6b35;
    }

    .bottom-action {
        position: fixed;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 200;
        background: rgba(255, 255, 255, 0.96);
        backdrop-filter: blur(8px);
        border-top: 1px solid #eceef3;
        padding: 10px 14px calc(10px + env(safe-area-inset-bottom));
        display: grid;
        grid-template-columns: 52px 1fr;
        gap: 10px;
    }
    .btn-wishlist {
        width: 52px;
        height: 48px;
        border-radius: 12px;
        border: 1px solid #ffd2bf;
        background: #fff4ef;
        color: #e25324;
        font-size: 20px;
        cursor: pointer;
    }
    .btn-wishlist.active {
        background: #ffeae2;
        border-color: #ffbc9e;
    }
    .btn-buy {
        width: 100%;
        border: none;
        border-radius: 12px;
        font-weight: 800;
        color: #fff;
        background: linear-gradient(135deg, #ff6b35, #ff8f4b);
        cursor: pointer;
        font-size: 14px;
        padding: 12px 14px;
        box-shadow: 0 8px 22px rgba(255, 107, 53, 0.35);
    }
    .btn-login {
        display: grid;
        place-items: center;
        text-decoration: none;
        color: #fff;
        border-radius: 12px;
        font-weight: 800;
        background: linear-gradient(135deg, #1a1f2e, #30384c);
        font-size: 14px;
        padding: 12px 14px;
    }

    @media (min-width: 768px) {
        .detail-container {
            max-width: 920px;
            margin: 0 auto;
            padding-top: 18px;
        }
        .hero {
            display: grid;
            grid-template-columns: 46% 54%;
        }
        .img-wrap {
            min-height: 320px;
        }
        .recommend-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }
    }
</style>
@endsection

@section('content')
@php
    $foto = $produk->foto ?? $produk->Foto ?? null;
    $deskripsi = $produk->deskripsi ?? $produk->Deskripsi ?? 'Tidak ada deskripsi untuk produk ini.';
    $rating = (float) ($produk->rating ?? 0);
    $terjual = (int) ($produk->total_terjual ?? 0);
    $stokRendah = (int) $produk->Stok <= 5;
    $isWish = in_array((int) $produk->ProdukID, $wishlistProdukIds ?? [], true);
@endphp

<div class="detail-container">
    <div class="hero">
        <div class="img-wrap">
            <a href="javascript:history.back()" class="btn-back" aria-label="Kembali">←</a>
            <span class="badge-cat">{{ $produk->kategori ?? 'Produk Pilihan' }}</span>

            @if($foto && file_exists(public_path('storage/' . $foto)))
                <img src="{{ asset('storage/' . $foto) }}" class="main-img" alt="{{ $produk->NamaProduk }}">
            @else
                <div class="img-empty">📦</div>
            @endif
        </div>

        <div class="hero-info">
            <div class="price-row">
                <div class="price">Rp {{ number_format($produk->Harga, 0, ',', '.') }}</div>
                <div class="stock-chip {{ $stokRendah ? 'low' : '' }}">
                    {{ $stokRendah ? 'Stok menipis' : 'Stok tersedia' }}: {{ $produk->Stok }}
                </div>
            </div>

            <h1 class="product-title">{{ $produk->NamaProduk }}</h1>

            <div class="meta-row">
                <div class="meta-pill">⭐ {{ number_format($rating, 1) }}</div>
                <div class="meta-pill">Terjual {{ number_format($terjual, 0, ',', '.') }}</div>
                <div class="meta-pill">Produk resmi TokoKu</div>
            </div>
        </div>
    </div>

    <div class="section-box">
        <div class="section-title">Deskripsi Produk</div>
        <div class="desc-text">{!! nl2br(e($deskripsi)) !!}</div>
    </div>

    @if(isset($rekomendasi) && $rekomendasi->count())
    <div class="section-box">
        <div class="section-title">Rekomendasi Serupa</div>
        <div class="recommend-grid">
            @foreach($rekomendasi as $item)
                @php $itemFoto = $item->foto ?? $item->Foto ?? null; @endphp
                <a href="{{ route('user.produk.detail', $item->ProdukID) }}" class="recommend-card">
                    @if($itemFoto && file_exists(public_path('storage/' . $itemFoto)))
                        <img src="{{ asset('storage/' . $itemFoto) }}" alt="{{ $item->NamaProduk }}" class="recommend-img">
                    @else
                        <div class="recommend-img" style="display:grid;place-items:center;font-size:34px;">📦</div>
                    @endif

                    <div class="recommend-info">
                        <div class="recommend-name">{{ Str::limit($item->NamaProduk, 36) }}</div>
                        <div class="recommend-price">Rp {{ number_format($item->Harga, 0, ',', '.') }}</div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    @endif
</div>

<div class="bottom-action">
    @if(Session::has('pelanggan_id'))
        <form action="{{ route('user.wishlist.toggle', $produk->ProdukID) }}" method="POST" class="js-wishlist-form">
            @csrf
            <button type="submit" class="btn-wishlist js-wishlist-btn {{ $isWish ? 'active' : '' }}" title="Wishlist">
                {{ $isWish ? '♥' : '♡' }}
            </button>
        </form>

        <form action="{{ route('user.keranjang.tambah', $produk->ProdukID) }}" method="POST">
            @csrf
            <button type="submit" class="btn-buy">Tambah ke Keranjang</button>
        </form>
    @else
        <a href="{{ route('user.login') }}" class="btn-login" style="grid-column: 1 / -1;">Login untuk Beli Produk</a>
    @endif
</div>
@endsection
