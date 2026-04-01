@extends('admin.user.app')

@section('title', 'Favorit Saya')

@section('styles')
<style>
    body { background-color: #f5f5f5; }
    .wishlist-header { background: white; padding: 15px 20px; border-bottom: 1px solid #eee; position: sticky; top: 0; z-index: 100; }

    .wishlist-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 8px;
        padding: 8px;
    }

    .wish-card {
        background: white;
        border-radius: 4px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .wish-img { width: 100%; height: 120px; object-fit: cover; }

    .wish-info { padding: 6px; flex: 1; }
    .wish-name { font-size: 12px; color: #333; height: 30px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; line-height: 1.3; margin-bottom: 4px; }
    .wish-price { color: #ee4d2d; font-weight: bold; font-size: 13px; }

    .btn-cart-wish {
        background: #ee4d2d;
        color: white;
        border: none;
        padding: 5px;
        font-size: 11px;
        width: 100%;
        margin-top: 6px;
        cursor: pointer;
        border-radius: 2px;
    }

    .btn-remove-wish {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(0,0,0,0.3);
        color: white;
        border: none;
        width: 25px;
        height: 25px;
        border-radius: 50%;
        font-size: 12px;
        cursor: pointer;
    }

    @media (min-width: 768px) {
        .wishlist-grid {
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        }

        .wish-img { height: 130px; }
    }
</style>
@endsection

@section('content')
<div class="wishlist-header">
    <a href="{{ route('/') }}" style="text-decoration: none; color: #333;">⬅️</a>
    <h2 style="font-size: 17px; margin: 0; display: inline; margin-left: 10px; font-weight: 600;">Favorit Saya</h2>
</div>

<div class="wishlist-grid">
    @forelse($wishlist as $item)
    <div class="wish-card">
        <form action="{{ route('user.wishlist.toggle', $item->ProdukID) }}" method="POST">
            @csrf
            <button type="submit" class="btn-remove-wish" onclick="return confirm('Hapus dari favorit?')">✕</button>
        </form>

        @if(!empty($item->foto))
            <img src="{{ asset('storage/' . $item->foto) }}" class="wish-img">
        @else
            <div class="wish-img" style="display:flex;align-items:center;justify-content:center;background:#f3f4f6;font-size:38px;">📦</div>
        @endif

        <div class="wish-info">
            <div class="wish-name">{{ $item->NamaProduk }}</div>
            <div class="wish-price">Rp {{ number_format($item->Harga, 0, ',', '.') }}</div>

            {{-- Tombol langsung masukkan ke keranjang --}}
            <form action="{{ route('user.keranjang.tambah', $item->ProdukID) }}" method="POST">
                @csrf
                <button type="submit" class="btn-cart-wish">+ Keranjang</button>
            </form>
        </div>
    </div>
    @empty
    <div style="grid-column: 1 / -1; text-align: center; padding: 100px 20px; color: #888;">
        <div style="font-size: 50px; margin-bottom: 10px;">❤️</div>
        <p>Belum ada produk favorit.</p>
        <a href="{{ route('/') }}" style="color: #ee4d2d; text-decoration: none; font-weight: bold;">Cari Produk</a>
    </div>
    @endforelse
</div>
@endsection
