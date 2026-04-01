<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthUser
{
    public function handle(Request $request, Closure $next)
    {
        if (Session::get('role') === 'admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Menu ini khusus akun user. Silakan login sebagai user untuk mengaksesnya.');
        }

        if (!Session::has('pelanggan_id')) {
            return redirect()->route('user.login')->withErrors(['Silakan login terlebih dahulu.']);
        }

        if (Session::get('role') !== 'user') {
            return redirect()->route('user.login')->withErrors(['Akses menu ini hanya untuk akun user.']);
        }

        return $next($request);
    }
}

