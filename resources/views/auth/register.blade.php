<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - TokoKu</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .wrapper {
            width: 100%;
            max-width: 960px;
            display: flex;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.12);
            margin: 20px;
        }

        .left-panel {
            flex: 1;
            background: #FF6B35;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .left-panel::before { content:''; position:absolute; width:220px; height:220px; border-radius:50%; background:rgba(255,255,255,0.08); top:-60px; right:-60px; }
        .left-panel::after { content:''; position:absolute; width:160px; height:160px; border-radius:50%; background:rgba(255,255,255,0.06); bottom:-40px; left:-40px; }

        .brand { font-size: 36px; font-weight: 800; letter-spacing: -1px; margin-bottom: 6px; }
        .brand-sub { font-size: 13px; opacity: 0.8; margin-bottom: 30px; letter-spacing: 1px; }
        .step-title { font-size: 16px; font-weight: 600; margin-bottom: 16px; opacity: 0.95; }

        .steps { display: flex; flex-direction: column; gap: 12px; width: 100%; }
        .step { display: flex; align-items: center; gap: 12px; }
        .step-num { width: 28px; height: 28px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; flex-shrink: 0; }
        .step-text { font-size: 13px; opacity: 0.9; }

        .right-panel { flex: 1.3; padding: 45px 45px; overflow-y: auto; }

        h2 { font-size: 24px; font-weight: 700; color: #1a1a1a; margin-bottom: 6px; }
        .sub-title { font-size: 14px; color: #888; margin-bottom: 28px; }

        .alert-error { background: #fff2f2; border: 1px solid #ffcdd2; border-radius: 10px; padding: 12px 16px; color: #c62828; font-size: 13px; margin-bottom: 20px; }

        .row2 { display: flex; gap: 14px; }
        .row2 .field { flex: 1; }

        .field { margin-bottom: 16px; }
        .field label { display: block; font-size: 12px; font-weight: 600; color: #555; margin-bottom: 7px; letter-spacing: 0.4px; }
        .field input, .field select {
            width: 100%; padding: 12px 14px;
            border: 1.5px solid #e8e8e8; border-radius: 10px;
            font-size: 14px; transition: all 0.2s; outline: none;
            color: #1a1a1a; background: #fafafa;
        }
        .field input:focus, .field select:focus { border-color: #FF6B35; background: white; box-shadow: 0 0 0 3px rgba(255,107,53,0.08); }

        .field textarea {
            width: 100%; padding: 12px 14px;
            border: 1.5px solid #e8e8e8; border-radius: 10px;
            font-size: 14px; transition: all 0.2s; outline: none;
            color: #1a1a1a; background: #fafafa;
            resize: vertical; min-height: 80px; font-family: inherit;
        }
        .field textarea:focus { border-color: #FF6B35; background: white; box-shadow: 0 0 0 3px rgba(255,107,53,0.08); }

        .section-label { font-size: 13px; font-weight: 700; color: #FF6B35; margin-bottom: 14px; margin-top: 6px; padding-bottom: 8px; border-bottom: 1.5px solid #fff0eb; letter-spacing: 0.5px; }

        .checkbox-row { display: flex; align-items: flex-start; gap: 10px; margin-bottom: 20px; }
        .checkbox-row input[type=checkbox] { width: 16px; height: 16px; accent-color: #FF6B35; cursor: pointer; margin-top: 2px; flex-shrink: 0; }
        .checkbox-row label { font-size: 13px; color: #666; cursor: pointer; line-height: 1.5; }
        .checkbox-row a { color: #FF6B35; text-decoration: none; font-weight: 500; }

        .btn-main { width: 100%; padding: 14px; background: #FF6B35; color: white; border: none; border-radius: 12px; font-size: 15px; font-weight: 700; cursor: pointer; transition: all 0.2s; }
        .btn-main:hover { background: #e55a25; transform: translateY(-1px); box-shadow: 0 8px 24px rgba(255,107,53,0.35); }

        .login-link { text-align: center; margin-top: 20px; font-size: 13px; color: #888; }
        .login-link a { color: #FF6B35; text-decoration: none; font-weight: 600; }

        @media (max-width: 650px) {
            .left-panel { display: none; }
            .right-panel { padding: 35px 25px; }
            .row2 { flex-direction: column; gap: 0; }
        }
    </style>
</head>
<body>

<div class="wrapper">
    <div class="left-panel">
        <div class="brand">TokoKu</div>
        <div class="brand-sub">BELANJA ONLINE TERPERCAYA</div>
        <div class="step-title">Langkah mudah bergabung:</div>
        <div class="steps">
            <div class="step"><div class="step-num">1</div><div class="step-text">Isi data diri kamu</div></div>
            <div class="step"><div class="step-num">2</div><div class="step-text">Buat kata sandi yang kuat</div></div>
            <div class="step"><div class="step-num">3</div><div class="step-text">Setujui syarat & ketentuan</div></div>
            <div class="step"><div class="step-num">4</div><div class="step-text">Mulai belanja sekarang!</div></div>
        </div>
    </div>

    <div class="right-panel">
        <h2>Buat Akun Baru ✨</h2>
        <p class="sub-title">Daftar gratis dan nikmati kemudahan belanja online</p>

        @if ($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('register.post') }}">
            @csrf

            <div class="section-label">DATA DIRI</div>

            <div class="row2">
                <div class="field">
                    <label>NAMA LENGKAP *</label>
                    <input type="text" name="NamaPelanggan" placeholder="Nama lengkap" value="{{ old('NamaPelanggan') }}" required />
                </div>
                <div class="field">
                    <label>NO. TELEPON *</label>
                    <input type="text" name="NomorTelepon" placeholder="08xxxxxxxxxx" value="{{ old('NomorTelepon') }}" required />
                </div>
            </div>

            <div class="field">
                <label>ALAMAT LENGKAP</label>
                <textarea name="Alamat" placeholder="Jl. Nama Jalan No. XX, Kota, Provinsi">{{ old('Alamat') }}</textarea>
            </div>

            <div class="section-label">AKUN & KEAMANAN</div>

            <div class="field">
                <label>EMAIL *</label>
                <input type="email" name="email" placeholder="contoh@email.com" value="{{ old('email') }}" required />
            </div>

            <div class="row2">
                <div class="field">
                    <label>KATA SANDI *</label>
                    <input type="password" name="password" placeholder="Min. 8 karakter" required />
                </div>
                <div class="field">
                    <label>KONFIRMASI KATA SANDI *</label>
                    <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi" required />
                </div>
            </div>

            <div class="checkbox-row">
                <input type="checkbox" id="agree" name="agree" required />
                <label for="agree">Saya telah membaca dan menyetujui <a href="#">Syarat & Ketentuan</a> serta <a href="#">Kebijakan Privasi</a> TokoKu</label>
            </div>

            <button type="submit" class="btn-main">Daftar Sekarang 🚀</button>
        </form>

        <div class="login-link">
            Sudah punya akun? <a href="{{ route('user.login') }}">Masuk di sini</a>
        </div>
    </div>
</div>

</body>
</html>
