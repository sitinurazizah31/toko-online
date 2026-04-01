@extends('admin.user.app')

@section('title', 'Profil Saya - TokoKu')

@section('styles')
<style>
    body { background-color: #f5f5f5; }

    /* Header ala Shopee */
    .shopee-header {
        background: linear-gradient(180deg, #f53d2d, #ff6633);
        padding: 60px 20px 30px;
        color: white;
        display: flex;
        align-items: center;
        gap: 15px;
        position: relative;
    }

    .shopee-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        border: 2px solid rgba(255,255,255,0.5);
        object-fit: cover;
    }

    .shopee-user-info h2 {
        font-size: 18px;
        font-weight: 600;
        margin: 0;
    }

    .shopee-user-info span {
        font-size: 12px;
        background: rgba(0,0,0,0.2);
        padding: 2px 8px;
        border-radius: 10px;
        display: inline-block;
        margin-top: 4px;
    }

    /* Pengaturan Icon di Pojok */
    .shopee-settings-icon {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 20px;
        color: white;
        text-decoration: none;
    }

    /* Container Menu */
    .menu-container {
        margin-top: -10px;
        background: white;
        border-radius: 15px 15px 0 0;
        padding: 20px 0;
        min-height: 500px;
    }

    .menu-group-title {
        padding: 10px 20px;
        font-size: 14px;
        color: #333;
        font-weight: 600;
        background: #fafafa;
        border-bottom: 1px solid #eee;
    }

    .menu-item {
        display: flex;
        align-items: center;
        padding: 15px 20px;
        text-decoration: none;
        color: #333;
        border-bottom: 1px solid #f5f5f5;
        transition: background 0.2s;
    }

    .menu-item:active { background: #f0f0f0; }

    .menu-icon {
        width: 25px;
        font-size: 18px;
        margin-right: 15px;
        color: #f53d2d;
        text-align: center;
    }

    .menu-text { flex: 1; font-size: 14px; }

    .menu-arrow { color: #ccc; font-size: 12px; }

    /* Tombol Logout ala Shopee */
    .logout-section {
        padding: 30px 20px;
    }

    .btn-logout {
        display: block;
        width: 100%;
        padding: 12px;
        text-align: center;
        background: white;
        color: #f53d2d;
        border: 1px solid #f53d2d;
        border-radius: 4px;
        text-decoration: none;
        font-weight: 600;
    }
</style>
@endsection

@section('content')
<div class="shopee-profile">
    <div class="shopee-header">
        <a href="{{ route('user.pengaturan') }}" class="shopee-settings-icon">⚙️</a>
        <img src="https://ui-avatars.com/api/?name={{ urlencode($pelanggan->NamaPelanggan) }}&background=fff&color=f53d2d" class="shopee-avatar">
        <div class="shopee-user-info">
            <h2>{{ $pelanggan->NamaPelanggan }}</h2>
            <span>Member {{ ucfirst($pelanggan->role ?? 'Classic') }}</span>
        </div>
    </div>

    <div class="menu-container">
        <div class="menu-group-title">Pesanan Saya</div>
        <a href="{{ route('user.pesanan') }}" class="menu-item">
            <div class="menu-icon">📦</div>
            <div class="menu-text">Riwayat Pesanan</div>
            <div class="menu-arrow">▶</div>
        </a>
        <a href="{{ route('user.pesanan', ['status' => 'belum_bayar']) }}" class="menu-item">
            <div class="menu-icon">💳</div>
            <div class="menu-text">Belum Bayar</div>
            <div class="menu-arrow">▶</div>
        </a>

        <div class="menu-group-title" style="margin-top: 15px;">Pengaturan Akun</div>
        <a href="{{ route('user.pengaturan') }}" class="menu-item">
            <div class="menu-icon">👤</div>
            <div class="menu-text">Ubah Profil ({{ $pelanggan->email }})</div>
            <div class="menu-arrow">▶</div>
        </a>
        <a href="{{ route('user.pengaturan') }}#alamat" class="menu-item">
            <div class="menu-icon">📍</div>
            <div class="menu-text">Alamat Saya</div>
            <div class="menu-arrow">▶</div>
        </a>
        <a href="{{ route('user.pengaturan') }}#telepon" class="menu-item">
            <div class="menu-icon">📞</div>
            <div class="menu-text">Nomor Telepon: {{ $pelanggan->NomorTelepon ?? '-' }}</div>
            <div class="menu-arrow">▶</div>
        </a>

        <div class="logout-section">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">Log Out</button>
            </form>
        </div>
    </div>
</div>
@endsection
