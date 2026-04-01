@extends('admin.user.app')

@section('title', 'Pesanan Saya - TokoKu')

@section('styles')
<style>
    .wrap { padding: 16px; }
    .head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
    .title { font-size: 18px; font-weight: 800; color: #1a1f2e; }
    .filters { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 14px; }
    .chip { text-decoration: none; padding: 8px 12px; border-radius: 999px; font-size: 12px; border: 1px solid #f0f0f0; color: #666; background: #fff; }
    .chip.active { background: #FF6B35; color: #fff; border-color: #FF6B35; }

    .card { background: #fff; border-radius: 12px; border: 1px solid #f0f0f0; overflow: hidden; }
    table { width: 100%; border-collapse: collapse; font-size: 13px; }
    th { text-align: left; padding: 12px 14px; color: #999; background: #fafafa; font-size: 11px; border-bottom: 1px solid #f0f0f0; }
    td { padding: 12px 14px; border-bottom: 1px solid #f7f7f7; color: #333; }
    tr:last-child td { border-bottom: none; }

    .badge { display: inline-block; padding: 4px 10px; border-radius: 999px; font-size: 11px; font-weight: 700; }
    .pay-done { background: #dcfce7; color: #15803d; }
    .pay-pending { background: #fff7ed; color: #c2410c; }
    .order-done { background: #dbeafe; color: #1d4ed8; }
    .order-proc { background: #f3e8ff; color: #7e22ce; }

    .empty { padding: 28px; text-align: center; color: #999; }
    .pagination { padding: 12px 14px; border-top: 1px solid #f0f0f0; }
</style>
@endsection

@section('content')
<div class="wrap">
    <div class="head">
        <div class="title">Pesanan Saya</div>
        <a href="{{ route('user.profil') }}" style="font-size:12px;color:#FF6B35;text-decoration:none">← Kembali ke Profil</a>
    </div>

    <div class="filters">
        <a class="chip {{ $status === 'belum_bayar' ? '' : 'active' }}" href="{{ route('user.pesanan') }}">Semua</a>
        <a class="chip {{ $status === 'belum_bayar' ? 'active' : '' }}" href="{{ route('user.pesanan', ['status' => 'belum_bayar']) }}">Belum Bayar</a>
    </div>

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>TANGGAL</th>
                    <th>TOTAL</th>
                    <th>PEMBAYARAN</th>
                    <th>PESANAN</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesanan as $item)
                @php
                    $tanggal = $item->TanggalPenjualan ? \Carbon\Carbon::parse($item->TanggalPenjualan)->format('d M Y') : \Carbon\Carbon::parse($item->created_at)->format('d M Y');
                    $payClass = ($item->status_pembayaran ?? '') === 'sudah_bayar' ? 'pay-done' : 'pay-pending';
                    $orderClass = in_array(($item->status_pesanan ?? ''), ['selesai', 'dikirim']) ? 'order-done' : 'order-proc';
                @endphp
                <tr>
                    <td>#{{ str_pad($item->PenjualanID, 4, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $tanggal }}</td>
                    <td>Rp {{ number_format($item->TotalHarga ?? 0, 0, ',', '.') }}</td>
                    <td><span class="badge {{ $payClass }}">{{ ucfirst($item->status_pembayaran ?? 'belum_bayar') }}</span></td>
                    <td><span class="badge {{ $orderClass }}">{{ ucfirst($item->status_pesanan ?? 'diproses') }}</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="empty">Belum ada data pesanan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination">
            {{ $pesanan->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
