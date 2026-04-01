@extends('admin.user.app')

@section('content')
<div class="cart-header" style="background: white; padding: 15px 20px; border-bottom: 1px solid #eee;">
    <a href="{{ route('/') }}" style="text-decoration: none; color: #333;">⬅️</a>
    <h2 style="font-size: 18px; margin: 0; display: inline; margin-left: 10px;">Keranjang Saya</h2>
</div>

<div class="cart-list" style="padding-bottom: 120px; background: #f5f5f5; min-height: 80vh;">
    {{-- PERBAIKAN: Menggunakan $keranjang, bukan $items --}}
    @forelse($keranjang as $item)
    <div class="cart-item" style="background: white; margin-top: 10px; padding: 15px; display: flex; gap: 15px; align-items: center;">
        <input type="checkbox" checked style="accent-color: #ee4d2d;">

        <img src="{{ asset('storage/' . $item->foto) }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">

        <div class="item-info" style="flex: 1;">
            <div class="item-name" style="font-size: 14px; font-weight: 500;">{{ $item->NamaProduk }}</div>
            <div class="item-price" style="color: #ee4d2d; font-weight: 700;">Rp {{ number_format($item->Harga, 0, ',', '.') }}</div>

            <div class="item-qty" style="display: flex; align-items: center; border: 1px solid #ddd; width: fit-content; margin-top: 10px;">
                <button style="padding: 2px 10px; background: none; border: none;">-</button>
                <input type="text" value="{{ $item->jumlah }}" readonly style="width: 30px; text-align: center; border: none; border-left: 1px solid #ddd; border-right: 1px solid #ddd; font-size: 12px;">
                <button style="padding: 2px 10px; background: none; border: none;">+</button>
            </div>
        </div>

        <form action="{{ route('user.keranjang.hapus', $item->KeranjangID) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" style="background: none; border: none; color: #999; cursor: pointer;">🗑️</button>
        </form>
    </div>
    @empty
    <div style="text-align: center; padding: 50px 20px;">
        <p style="color: #888;">Keranjang kosong.</p>
    </div>
    @endforelse
</div>

@if($keranjang->isNotEmpty())
<div style="position: fixed; bottom: 65px; left: 0; right: 0; background: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 -2px 10px rgba(0,0,0,0.05);">
    <div>
        <p style="font-size: 12px; color: #888; margin: 0;">Total:</p>
        <h3 style="color: #ee4d2d; margin: 0; font-size: 18px;">Rp {{ number_format($totalHarga, 0, ',', '.') }}</h3>
    </div>
    <form action="{{ route('user.keranjang.checkout') }}" method="POST" style="display:flex;align-items:center;gap:10px;">
        @csrf
        <select name="metode" style="padding:10px;border:1px solid #ddd;border-radius:6px;font-size:13px;" required>
            <option value="Transfer">Transfer</option>
            <option value="COD">COD</option>
            <option value="E-Wallet">E-Wallet</option>
        </select>
        <button type="submit" style="background: #ee4d2d; color: white; padding: 12px 30px; border-radius: 4px; border: none; font-weight: 700; cursor: pointer;">Checkout</button>
    </form>
</div>
@endif
@endsection
