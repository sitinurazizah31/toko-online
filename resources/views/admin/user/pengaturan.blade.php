@extends('admin.user.app')

@section('title', 'Pengaturan Akun - TokoKu')

@section('styles')
<style>
    .wrap { padding: 16px; }
    .title { font-size: 18px; font-weight: 800; color: #1a1f2e; margin-bottom: 14px; }
    .card { background: #fff; border: 1px solid #f0f0f0; border-radius: 12px; padding: 16px; }
    .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .field { margin-bottom: 12px; }
    .field label { display: block; font-size: 12px; color: #666; margin-bottom: 6px; font-weight: 600; }
    .field input, .field textarea { width: 100%; border: 1px solid #e8e8e8; border-radius: 8px; padding: 10px 12px; font-size: 13px; outline: none; }
    .field textarea { min-height: 86px; resize: vertical; }
    .field input:focus, .field textarea:focus { border-color: #FF6B35; }
    .btn-save { margin-top: 4px; width: 100%; border: none; background: #FF6B35; color: #fff; border-radius: 10px; padding: 12px; font-weight: 700; font-size: 14px; cursor: pointer; }
    .btn-save:hover { background: #e55a25; }
    .hint { margin-top: 10px; color: #999; font-size: 12px; }

    @media (max-width: 720px) {
        .grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<div class="wrap">
    <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:14px">
        <div class="title">Pengaturan Akun</div>
        <a href="{{ route('user.profil') }}" style="font-size:12px;color:#FF6B35;text-decoration:none">← Kembali ke Profil</a>
    </div>

    @if($errors->any())
        <div class="alert-error" style="margin:0 0 12px 0">{{ $errors->first() }}</div>
    @endif

    <div class="card">
        <form action="{{ route('user.pengaturan.update') }}" method="POST">
            @csrf

            <div class="grid">
                <div class="field">
                    <label>NAMA LENGKAP</label>
                    <input type="text" name="NamaPelanggan" value="{{ old('NamaPelanggan', $pelanggan->NamaPelanggan) }}" required>
                </div>
                <div class="field" id="telepon">
                    <label>NOMOR TELEPON</label>
                    <input type="text" name="NomorTelepon" value="{{ old('NomorTelepon', $pelanggan->NomorTelepon) }}" required>
                </div>
            </div>

            <div class="field">
                <label>EMAIL</label>
                <input type="email" name="email" value="{{ old('email', $pelanggan->email) }}" required>
            </div>

            <div class="field" id="alamat">
                <label>ALAMAT</label>
                <textarea name="Alamat">{{ old('Alamat', $pelanggan->Alamat) }}</textarea>
            </div>

            <div class="grid">
                <div class="field">
                    <label>PASSWORD BARU (opsional)</label>
                    <input type="password" name="password" placeholder="Kosongkan jika tidak ingin ubah">
                </div>
                <div class="field">
                    <label>KONFIRMASI PASSWORD BARU</label>
                    <input type="password" name="password_confirmation" placeholder="Ulangi password baru">
                </div>
            </div>

            <button type="submit" class="btn-save">Simpan Pengaturan</button>
            <div class="hint">Jika password tidak diubah, biarkan kolom password kosong.</div>
        </form>
    </div>
</div>
@endsection
