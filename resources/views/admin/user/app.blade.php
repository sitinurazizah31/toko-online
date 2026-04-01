<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TokoKu') - Belanja Online</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f5f5; padding-bottom: 70px; }

        .navbar { background: #FF6B35; padding: 12px 16px; display: flex; align-items: center; gap: 10px; position: sticky; top: 0; z-index: 100; }
        .nav-logo { color: white; font-size: 20px; font-weight: 800; text-decoration: none; flex-shrink: 0; }
        .nav-icons { display: flex; gap: 10px; align-items: center; margin-left: auto; }
        .nav-icon { color: white; font-size: 20px; text-decoration: none; position: relative; }
        .nav-badge { position: absolute; top: -6px; right: -6px; background: #ffcc00; color: #333; border-radius: 50%; width: 16px; height: 16px; font-size: 9px; font-weight: 700; display: flex; align-items: center; justify-content: center; }
        .btn-login-nav { background: white; color: #FF6B35; border: none; padding: 7px 14px; border-radius: 8px; font-size: 12px; font-weight: 700; cursor: pointer; text-decoration: none; white-space: nowrap; }

        .bottom-nav { position: fixed; bottom: 0; left: 0; right: 0; background: white; border-top: 1px solid #f0f0f0; display: flex; z-index: 100; box-shadow: 0 -2px 10px rgba(0,0,0,0.06); }
        .nav-tab { flex: 1; display: flex; flex-direction: column; align-items: center; padding: 8px 0 6px; gap: 3px; font-size: 10px; color: #aaa; text-decoration: none; }
        .nav-tab.active { color: #FF6B35; }
        .nav-tab-icon { font-size: 20px; }

        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 12px 16px; color: #166534; font-size: 13px; margin: 12px 16px; }
        .alert-error { background: #fff2f2; border: 1px solid #ffcdd2; border-radius: 10px; padding: 12px 16px; color: #c62828; font-size: 13px; margin: 12px 16px; }
        .wishlist-toast {
            position: fixed;
            left: 50%;
            bottom: 84px;
            transform: translateX(-50%) translateY(12px);
            background: rgba(26, 31, 46, 0.95);
            color: #fff;
            padding: 10px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            opacity: 0;
            pointer-events: none;
            transition: all 0.2s ease;
            z-index: 1200;
            max-width: 88vw;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .wishlist-toast.show {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
    </style>
    @yield('styles')
</head>
<body>

<div class="navbar">
    <a href="{{ route('/') }}" class="nav-logo">TokoKu</a>
    <div class="nav-icons">
        @if(Session::has('pelanggan_id'))
            <a href="{{ route('user.keranjang') }}" class="nav-icon">
                🛒
                @if(isset($jumlahKeranjang) && $jumlahKeranjang > 0)
                    <div class="nav-badge">{{ $jumlahKeranjang }}</div>
                @endif
            </a>
        @else
            <a href="{{ route('user.login') }}" class="btn-login-nav">Masuk</a>
        @endif
    </div>
</div>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert-error">{{ session('error') }}</div>
@endif

@yield('content')

<div class="bottom-nav">
    <a href="{{ route('/') }}" class="nav-tab {{ request()->is('/') ? 'active' : '' }}">
        <div class="nav-tab-icon">🏠</div>Beranda
    </a>
    <a href="{{ route('user.pencarian') }}" class="nav-tab {{ request()->routeIs('user.pencarian') ? 'active' : '' }}">
        <div class="nav-tab-icon">🔍</div>Cari
    </a>
    <a href="{{ Session::has('pelanggan_id') ? route('user.keranjang') : route('user.login') }}" class="nav-tab {{ request()->routeIs('user.keranjang') ? 'active' : '' }}">
        <div class="nav-tab-icon">🛒</div>Keranjang
    </a>
    <a href="{{ Session::has('pelanggan_id') ? route('user.wishlist') : route('user.login') }}" class="nav-tab {{ request()->routeIs('user.wishlist') ? 'active' : '' }}">
        <div class="nav-tab-icon">❤️</div>Wishlist
    </a>
    <a href="{{ Session::has('pelanggan_id') ? route('user.profil') : route('user.login') }}" class="nav-tab {{ request()->routeIs('user.profil') ? 'active' : '' }}">
        <div class="nav-tab-icon">👤</div>Profil
    </a>
</div>

<div id="wishlistToast" class="wishlist-toast" aria-live="polite"></div>

<script>
let wishlistToastTimer = null;

function showWishlistToast(message) {
    const toast = document.getElementById('wishlistToast');
    if (!toast) return;

    toast.textContent = message;
    toast.classList.add('show');

    if (wishlistToastTimer) {
        clearTimeout(wishlistToastTimer);
    }

    wishlistToastTimer = setTimeout(function () {
        toast.classList.remove('show');
    }, 1300);
}

document.addEventListener('click', async function (e) {
    const button = e.target.closest('.js-wishlist-btn');
    if (!button) return;

    e.preventDefault();
    e.stopPropagation();

    const form = button.closest('.js-wishlist-form');
    if (!form) return;
    if (button.dataset.loading === '1') return;

    button.dataset.loading = '1';
    button.classList.add('is-animating');

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error('Wishlist request failed');
        }

        const isActive = button.classList.contains('active');
        if (isActive) {
            button.classList.remove('active');
            button.textContent = '♡';
            showWishlistToast('Dihapus dari wishlist');
        } else {
            button.classList.add('active');
            button.textContent = '♥';
            showWishlistToast('Ditambahkan ke wishlist');
        }
    } catch (error) {
        // Fallback: submit normal jika fetch gagal.
        form.submit();
        return;
    } finally {
        button.dataset.loading = '0';
        setTimeout(function () {
            button.classList.remove('is-animating');
        }, 240);
    }
});
</script>

@yield('scripts')
</body>
</html>
