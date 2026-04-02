@extends('admin.layouts.app')

@section('title', 'Pengiriman')
@section('page_title', 'Data Pengiriman')
@section('page_sub', 'Daftar pengiriman')

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
    display: inline-block;
}

/* Status colors */
.badge-diproses { background: #f59e0b; } /* orange */
.badge-diterima { background: #10b981; } /* green */
.badge-default  { background: #6b7280; } /* abu-abu */

/* Button */
.btn-status {
    background: linear-gradient(135deg, #28a745, #218838);
    padding: 8px 16px;
    color: white;
    border-radius: 8px;
    font-size: 12px;
    font-weight: bold;
    text-decoration: none;
    transition: 0.3s;
    display: inline-block;
    cursor: pointer;
    border: none;
}

.btn-status:hover {
    transform: scale(1.05);
    box-shadow: 0 0 15px rgba(40, 167, 69, 0.5);
}

.empty {
    text-align: center;
    padding: 30px;
    color: #9ca3af;
    font-weight: bold;
}
</style>

<div class="container-genz">

    <div class="header-genz">
        <h2>🚚 Data Pengiriman</h2>
    </div>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 8px; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    <table class="table-genz">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Pelanggan</th>
                <th>Alamat</th>
                <th>Metode</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengiriman as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>{{ $p->nama }}</td>
                <td>{{ $p->alamat ?? '-' }}</td>
                <td>{{ $p->metode }}</td>
                <td>
                    @php
                        $statusClass = match(strtolower($p->status)) {
                            'diproses'  => 'badge-diproses',
                            'diterima'  => 'badge-diterima',
                            default     => 'badge-default'
                        };
                    @endphp
                    <span class="badge {{ $statusClass }}">{{ ucfirst($p->status) }}</span>
                </td>
                <td>
                    @if(strtolower($p->status) == 'diproses')
                    <form action="{{ route('admin.pengiriman.selesai', $p->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn-status" onclick="return confirm('Konfirmasi bahwa pesanan ini sudah sampai?')">
                            ✅ Selesaikan Pesanan
                        </button>
                    </form>
                    @else
                    <span style="color: #10b981; font-weight: bold;">🎉 Transaksi Selesai</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="empty">😢 Belum ada pengiriman aktif</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection