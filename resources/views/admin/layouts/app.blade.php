<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - TokoKu</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f6fb; display: flex; min-height: 100vh; }
        .sidebar { width: 230px; background: #1a1f2e; display: flex; flex-direction: column; flex-shrink: 0; min-height: 100vh; position: fixed; top: 0; left: 0; height: 100%; z-index: 100; }
        .sidebar-brand { padding: 24px 20px; border-bottom: 1px solid rgba(255,255,255,0.07); }
        .brand-name { font-size: 20px; font-weight: 800; color: white; letter-spacing: -0.5px; }
        .brand-sub { font-size: 11px; color: rgba(255,255,255,0.35); margin-top: 2px; letter-spacing: 1px; }
        .sidebar-menu { padding: 16px 0; flex: 1; overflow-y: auto; }
        .menu-label { font-size: 10px; font-weight: 700; color: rgba(255,255,255,0.25); padding: 12px 20px 6px; letter-spacing: 1px; }
        .menu-item { display: flex; align-items: center; gap: 10px; padding: 11px 20px; color: rgba(255,255,255,0.55); font-size: 13px; text-decoration: none; transition: all 0.2s; border-left: 3px solid transparent; }
        .menu-item:hover { background: rgba(255,255,255,0.06); color: white; }
        .menu-item.active { background: rgba(255,107,53,0.15); color: #FF6B35; border-left-color: #FF6B35; }
        .menu-icon { font-size: 16px; width: 20px; text-align: center; }
        .sidebar-bottom { padding: 16px 20px; border-top: 1px solid rgba(255,255,255,0.07); }
        .admin-info { display: flex; align-items: center; gap: 10px; }
        .admin-avatar { width: 34px; height: 34px; background: #FF6B35; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; color: white; flex-shrink: 0; }
        .admin-name { font-size: 13px; color: white; font-weight: 500; }
        .admin-role { font-size: 11px; color: rgba(255,255,255,0.35); }
        .logout-btn { display: block; margin-top: 10px; padding: 9px 14px; background: rgba(255,107,53,0.15); color: #FF6B35; border-radius: 8px; text-align: center; font-size: 12px; font-weight: 600; text-decoration: none; transition: all 0.2s; border: none; width: 100%; cursor: pointer; }
        .logout-btn:hover { background: rgba(255,107,53,0.25); }
        .main { flex: 1; display: flex; flex-direction: column; margin-left: 230px; min-height: 100vh; }
        .topbar { background: white; padding: 166px 28px; /* diatur ulang jika perlu */ padding: 16px 28px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #eef0f5; position: sticky; top: 0; z-index: 50; }
        .page-title { font-size: 18px; font-weight: 700; color: #1a1f2e; }
        .page-sub { font-size: 12px; color: #999; margin-top: 2px; }
        .topbar-right { display: flex; align-items: center; gap: 14px; }
        .notif-btn { width: 36px; height: 36px; background: #f4f6fb; border-radius: 10px; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 16px; position: relative; text-decoration: none; }
        .notif-dot { width: 8px; height: 8px; background: #FF6B35; border-radius: 50%; position: absolute; top: 6px; right: 6px; }
        .date-badge { font-size: 12px; color: #888; background: #f4f6fb; padding: 7px 14px; border-radius: 10px; }
        .content { padding: 24px 28px; flex: 1; }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 12px 16px; color: #166534; font-size: 13px; margin-bottom: 20px; }
        .alert-error { background: #fff2f2; border: 1px solid #ffcdd2; border-radius: 10px; padding: 12px 16px; color: #c62828; font-size: 13px; margin-bottom: 20px; }
    </style>
    @yield('styles')
</head>
<body>

<div class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-name">TokoKu</div>
        <div class="brand-sub">ADMIN PANEL</div>
    </div>
    <div class="sidebar-menu">
        <div class="menu-label">UTAMA</div>
        <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="menu-icon">📊</span> Dashboard
        </a>
        <a href="{{ route('admin.produk') }}" class="menu-item {{ request()->routeIs('admin.produk*') ? 'active' : '' }}">
            <span class="menu-icon">📦</span> Produk
        </a>
        <a href="{{ route('admin.pesanan') }}" class="menu-item {{ request()->routeIs('admin.pesanan*') ? 'active' : '' }}">
            <span class="menu-icon">🛒</span> Pesanan
        </a>
        <a href="{{ route('admin.pelanggan') }}" class="menu-item {{ request()->routeIs('admin.pelanggan*') ? 'active' : '' }}">
            <span class="menu-icon">👥</span> Pelanggan
        </a>

        <div class="menu-label">KEUANGAN</div>
        <a href="{{ route('admin.pembayaran') }}" class="menu-item {{ request()->routeIs('admin.pembayaran*') ? 'active' : '' }}">
            <span class="menu-icon">💳</span> Pembayaran
        </a>
        <a href="{{ route('admin.pengiriman') }}" class="menu-item {{ request()->routeIs('admin.pengiriman*') ? 'active' : '' }}">
            <span class="menu-icon">🚚</span> Pengiriman
        </a>
        <a href="{{ route('admin.laporan') }}" class="menu-item {{ request()->routeIs('admin.laporan*') ? 'active' : '' }}">
            <span class="menu-icon">📈</span> Laporan
        </a>
    </div>
    
    <div class="sidebar-bottom">
        <div class="admin-info">
            <div class="admin-avatar">{{ strtoupper(substr(Session::get('nama_pelanggan', 'A'), 0, 1)) }}</div>
            <div>
                <div class="admin-name">{{ Session::get('nama_pelanggan', 'Admin') }}</div>
                <div class="admin-role">Administrator</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">🚪 Keluar</button>
        </form>
    </div>
</div>

<div class="main">
    <div class="topbar">
        <div>
            <div class="page-title">@yield('page_title', 'Dashboard')</div>
            <div class="page-sub">@yield('page_sub', 'Selamat datang kembali!')</div>
        </div>
        <div class="topbar-right">
            <a class="notif-btn" href="#"><span>🔔</span><div class="notif-dot"></div></a>
            <div class="date-badge">{{ \Carbon\Carbon::now()->translatedFormat('l, d M Y') }}</div>
        </div>
    </div>

    <div class="content">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif
        @yield('content')
    </div>
</div>

@yield('scripts')
</body>
</html>