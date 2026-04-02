@extends('admin.layouts.app')

@section('title', 'Pembayaran')
@section('page_title', 'Data Pembayaran')
@section('page_sub', 'Daftar pembayaran')

@section('content')

<style>
/* Container card */
.container-genz {
    background: #ffffff;
    padding: 25px;
    border-radius: 16px;
    box-shadow: 0 0 30px rgba(143, 121, 121, 0.1);
    margin-top: 20px;
}

/* Header */
.header-genz {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.header-genz h2 {
    color: #f97316;
    font-weight: bold;
    margin: 0;
}

/* Table */
.table-genz {
    width: 100%;
    border-collapse: collapse;
    overflow: hidden;
    border-radius: 12px;
}

.table-genz thead {
    background: linear-gradient(135deg, #f97316, #fb923c);
}

.table-genz th {
    padding: 14px;
    color: white;
    text-align: left;
    font-size: 14px;
}

.table-genz td {
    padding: 14px;
    color: #000000;
    vertical-align: middle;
}

.table-genz tbody tr {
    border-bottom: 1px solid #e5e7eb;
    transition: 0.2s;
}

.table-genz tbody tr:hover {
    background: rgba(251,146,60,0.1);
}

/* Badge status */
.badge {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: bold;
    color: white;
}

/* Status colors */
.badge-menunggu { background: #f59e0b; }
.badge-berhasil { background: #10b981; }
.badge-dikirim  { background: #3b82f6; } /* Warna biru untuk status dikirim */
.badge-gagal    { background: #ef4444; }
.badge-default  { background: #6b7280; }

/* Button */
.btn-status {
    background: linear-gradient(135deg, #f97316, #fb923c);
    padding: 6px 12px;
    color: white;
    border-radius: 8px;
    font-size: 12px;
    text-decoration: none;
    transition: 0.3s;
    display: inline-block;
    cursor: pointer;
    border: none;
}

.btn-kirim {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    padding: 6px 12px;
    color: white;
    border-radius: 8px;
    font-size: 12px;
    text-decoration: none;
    transition: 0.3s;
    display: inline-block;
    cursor: pointer;
    border: none;
}

.btn-status:hover, .btn-kirim:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

/* Empty message */
.empty {
    text-align: center;
    padding: 30px;
    color: #9ca3af;
    font-weight: bold;
}
</style>

<div class="container-genz">

    <div class="header-genz">
        <h2>✨ Data Pembayaran</h2>
    </div>

    <table class="table-genz">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Metode</th>
                <th>Total</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pembayaran as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>{{ $p->nama }}</td>
                <td>{{ $p->metode }}</td>
                <td>Rp {{ number_format($p->total, 0, ',', '.') }}</td>
                <td>
                    @php
                        $statusClass = match(strtolower($p->status)) {
                            'menunggu' => 'badge-menunggu',
                            'berhasil' => 'badge-berhasil',
                            'dikirim'  => 'badge-dikirim',
                            'gagal'    => 'badge-gagal',
                            default    => 'badge-default'
                        };
                    @endphp
                    <span class="badge {{ $statusClass }}">{{ ucfirst($p->status) }}</span>
                </td>
                <td>
                    {{-- Tombol Selesaikan (Hanya muncul jika status masih Menunggu) --}}
                    @if(strtolower($p->status) == 'menunggu')
                    <form action="{{ route('admin.pembayaran.update', $p->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="berhasil">
                        <button class="btn-status" onclick="return confirm('Ubah status menjadi Berhasil?')">✔ Selesaikan</button>
                    </form>
                    @endif

                    {{-- Tombol Kirim (Hanya muncul jika status Berhasil) --}}
                    @if(strtolower($p->status) == 'berhasil')
                    <form action="{{ route('admin.pembayaran.kirim', $p->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button class="btn-kirim" onclick="return confirm('Proses pengiriman barang ini?')">🚀 Kirim</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="empty">😢 Belum ada pembayaran</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection