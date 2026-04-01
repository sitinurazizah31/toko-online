@extends('admin.layouts.app')

@section('title', 'Manajemen Produk')
@section('page_title', 'Manajemen Produk')
@section('page_sub', 'Kelola semua produk toko')

@section('styles')
<style>
    .topbar-action { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
    .btn-primary { padding: 10px 20px; background: #FF6B35; color: white; border: none; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
    .btn-primary:hover { background: #e55a25; }

    .filter-bar { background: white; border-radius: 12px; padding: 16px 20px; border: 1px solid #f0f0f0; margin-bottom: 20px; display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }
    .search-input { flex: 1; min-width: 200px; padding: 9px 14px; border: 1.5px solid #e8e8e8; border-radius: 8px; font-size: 13px; outline: none; }
    .search-input:focus { border-color: #FF6B35; }
    .select-filter { padding: 9px 14px; border: 1.5px solid #e8e8e8; border-radius: 8px; font-size: 13px; outline: none; background: white; cursor: pointer; }
    .btn-filter { padding: 9px 18px; background: #FF6B35; color: white; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; }

    .card { background: white; border-radius: 14px; border: 1px solid #f0f0f0; overflow: hidden; }
    table { width: 100%; border-collapse: collapse; font-size: 13px; }
    th { text-align: left; padding: 12px 16px; font-size: 11px; font-weight: 700; color: #aaa; letter-spacing: 0.5px; border-bottom: 2px solid #f0f0f0; background: #fafafa; }
    td { padding: 14px 16px; border-bottom: 1px solid #f8f8f8; color: #333; vertical-align: middle; }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background: #fafbff; }

    .foto-box { width: 48px; height: 48px; border-radius: 10px; object-fit: cover; border: 1px solid #f0f0f0; }
    .foto-placeholder { width: 48px; height: 48px; border-radius: 10px; background: #f8f8f8; display: flex; align-items: center; justify-content: center; font-size: 22px; border: 1px solid #f0f0f0; }
    .prod-name { font-weight: 600; color: #1a1f2e; margin-bottom: 2px; }
    .prod-id { font-size: 11px; color: #aaa; }
    .badge-kat { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; background: #fff0eb; color: #FF6B35; }
    .stok-ok { color: #16a34a; font-weight: 700; }
    .stok-warn { color: #ca8a04; font-weight: 700; }
    .stok-danger { color: #dc2626; font-weight: 700; }

    .actions { display: flex; gap: 6px; }
    .btn-edit { padding: 6px 14px; background: #eff6ff; color: #2563eb; border: none; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; }
    .btn-edit:hover { background: #dbeafe; }
    .btn-del { padding: 6px 14px; background: #fff2f2; color: #dc2626; border: none; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 4px; }
    .btn-del:hover { background: #fee2e2; }

    .pagination-wrap { display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; border-top: 1px solid #f0f0f0; font-size: 13px; color: #888; }

    /* MODAL */
    .modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.45); display: flex; align-items: center; justify-content: center; z-index: 999; }
    .modal { background: white; border-radius: 16px; width: 100%; max-width: 540px; max-height: 90vh; overflow-y: auto; padding: 28px; margin: 20px; }
    .modal-title { font-size: 18px; font-weight: 800; color: #1a1f2e; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
    .modal-close { width: 30px; height: 30px; border: none; background: #f4f6fb; border-radius: 8px; cursor: pointer; font-size:16px; }
    .row2 { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .field { margin-bottom: 14px; }
    .field label { display: block; font-size: 12px; font-weight: 600; color: #555; margin-bottom: 6px; letter-spacing: 0.3px; }
    .field input, .field select, .field textarea { width: 100%; padding: 10px 14px; border: 1.5px solid #e8e8e8; border-radius: 8px; font-size: 13px; outline: none; font-family: inherit; background: #fafafa; }
    .field input:focus, .field select:focus, .field textarea:focus { border-color: #FF6B35; background: white; }
    .field textarea { resize: vertical; min-height: 80px; }
    .upload-area { border: 2px dashed #e8e8e8; border-radius: 10px; padding: 20px; text-align: center; cursor: pointer; margin-bottom: 14px; transition: all 0.2s; }
    .upload-area:hover { border-color: #FF6B35; background: #fff8f6; }
    .upload-icon { font-size: 28px; margin-bottom: 8px; }
    .upload-text { font-size: 13px; color: #888; }
    .upload-text span { color: #FF6B35; font-weight: 600; }
    .btn-save { width: 100%; padding: 12px; background: #FF6B35; color: white; border: none; border-radius: 10px; font-size: 14px; font-weight: 700; cursor: pointer; margin-top: 6px; }
    .btn-save:hover { background: #e55a25; }
    .hidden { display: none !important; }

    .preview-img { width: 100%; max-height: 150px; object-fit: cover; border-radius: 8px; margin-bottom: 10px; }
</style>
@endsection

@section('content')

<div class="topbar-action">
    <div>
        <span style="font-size:13px;color:#888">Total: <strong style="color:#1a1f2e">{{ $produk->total() }} produk</strong></span>
    </div>
    <button class="btn-primary" onclick="bukaModal('modalTambah')">＋ Tambah Produk</button>
</div>

{{-- FILTER --}}
<form method="GET" action="{{ route('admin.produk') }}">
    <div class="filter-bar">
        <input class="search-input" type="text" name="search" placeholder="🔍  Cari nama produk..." value="{{ request('search') }}" />
        <select class="select-filter" name="kategori">
            <option value="">Semua Kategori</option>
            @foreach($kategori as $kat)
            <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
            @endforeach
        </select>
        <select class="select-filter" name="stok">
            <option value="">Semua Stok</option>
            <option value="aman" {{ request('stok') == 'aman' ? 'selected' : '' }}>Stok Aman (&gt;10)</option>
            <option value="menipis" {{ request('stok') == 'menipis' ? 'selected' : '' }}>Stok Menipis (1-10)</option>
            <option value="habis" {{ request('stok') == 'habis' ? 'selected' : '' }}>Habis (0)</option>
        </select>
        <button type="submit" class="btn-filter">Cari</button>
    </div>
</form>

{{-- TABEL PRODUK --}}
<div class="card">
    <table>
        <thead>
            <tr>
                <th>FOTO</th>
                <th>NAMA PRODUK</th>
                <th>KATEGORI</th>
                <th>HARGA</th>
                <th>STOK</th>
                <th>RATING</th>
                <th>AKSI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($produk as $p)
            @php
                $stokClass = $p->Stok == 0 ? 'stok-danger' : ($p->Stok <= 10 ? 'stok-warn' : 'stok-ok');
            @endphp
            <tr>
                <td>
                    @if($p->foto && file_exists(public_path('storage/'.$p->foto)))
                        <img src="{{ asset('storage/'.$p->foto) }}" class="foto-box" alt="{{ $p->NamaProduk }}">
                    @else
                        <div class="foto-placeholder">📦</div>
                    @endif
                </td>
                <td>
                    <div class="prod-name">{{ $p->NamaProduk }}</div>
                    <div class="prod-id">#{{ str_pad($p->ProdukID, 3, '0', STR_PAD_LEFT) }}</div>
                </td>
                <td><span class="badge-kat">{{ $p->kategori ?? '-' }}</span></td>
                <td>Rp {{ number_format($p->Harga, 0, ',', '.') }}</td>
                <td><span class="{{ $stokClass }}">{{ $p->Stok }}</span></td>
                <td>⭐ {{ number_format($p->rating, 1) }}</td>
                <td>
                    <div class="actions">
                        @php
                            $fotoPath = $p->foto;
                            if ($fotoPath && !str_contains($fotoPath, '/')) {
                                $fotoPath = 'produk/' . $fotoPath;
                            }
                        @endphp
                        <button
                            type="button"
                            class="btn-edit"
                            data-id="{{ $p->ProdukID }}"
                            data-nama="{{ $p->NamaProduk }}"
                            data-harga="{{ $p->Harga }}"
                            data-stok="{{ $p->Stok }}"
                            data-kategori="{{ $p->kategori }}"
                            data-deskripsi="{{ $p->deskripsi }}"
                            data-foto-url="{{ $fotoPath ? asset('storage/' . $fotoPath) : '' }}"
                            onclick="bukaEditFromButton(this)"
                        >✏️ Edit</button>
                        <form method="POST" action="{{ route('admin.produk.destroy', $p->ProdukID) }}" onsubmit="return confirm('Hapus produk ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-del">🗑 Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;color:#aaa;padding:40px">
                    Belum ada produk. <a href="#" onclick="bukaModal('modalTambah')" style="color:#FF6B35">Tambah sekarang</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination-wrap">
        <span>Menampilkan {{ $produk->firstItem() ?? 0 }}-{{ $produk->lastItem() ?? 0 }} dari {{ $produk->total() }} produk</span>
        {{ $produk->withQueryString()->links() }}
    </div>
</div>

{{-- MODAL TAMBAH --}}
<div class="modal-overlay hidden" id="modalTambah">
    <div class="modal">
        <div class="modal-title">
            Tambah Produk Baru
            <button class="modal-close" onclick="tutupModal('modalTambah')">✕</button>
        </div>
        <form method="POST" action="{{ route('admin.produk.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="upload-area" onclick="document.getElementById('fotoTambah').click()">
                <img id="previewTambah" class="preview-img hidden" src="" alt="Preview">
                <div id="uploadIconTambah">
                    <div class="upload-icon">📸</div>
                    <div class="upload-text">Klik untuk upload foto<br><span>PNG, JPG maks 2MB</span></div>
                </div>
            </div>
            <input type="file" id="fotoTambah" name="foto" accept="image/*" class="hidden" onchange="previewFoto(this,'previewTambah','uploadIconTambah')">

            <div class="field"><label>NAMA PRODUK *</label><input type="text" name="NamaProduk" placeholder="Nama produk" required /></div>
            <div class="row2">
                <div class="field"><label>HARGA (Rp) *</label><input type="number" name="Harga" placeholder="150000" min="0" required /></div>
                <div class="field"><label>STOK *</label><input type="number" name="Stok" placeholder="50" min="0" required /></div>
            </div>
            <div class="field">
                <label>KATEGORI *</label>
                <select name="kategori" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option>Pakaian</option>
                    <option>Sepatu</option>
                    <option>Tas</option>
                    <option>Aksesoris</option>
                    <option>Elektronik</option>
                    <option>Lainnya</option>
                </select>
            </div>
            <div class="field"><label>DESKRIPSI</label><textarea name="deskripsi" placeholder="Deskripsi produk..."></textarea></div>
            <button type="submit" class="btn-save">💾 Simpan Produk</button>
        </form>
    </div>
</div>

{{-- MODAL EDIT --}}
<div class="modal-overlay hidden" id="modalEdit">
    <div class="modal">
        <div class="modal-title">
            Edit Produk
            <button class="modal-close" onclick="tutupModal('modalEdit')">✕</button>
        </div>
        <form method="POST" id="formEdit" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="upload-area" onclick="document.getElementById('fotoEdit').click()">
                <img id="previewEdit" class="preview-img" src="" alt="Preview">
                <div id="uploadIconEdit" class="hidden">
                    <div class="upload-icon">📸</div>
                    <div class="upload-text">Klik untuk ganti foto<br><span>PNG, JPG maks 2MB</span></div>
                </div>
            </div>
            <input type="file" id="fotoEdit" name="foto" accept="image/*" class="hidden" onchange="previewFoto(this,'previewEdit','uploadIconEdit')">

            <div class="field"><label>NAMA PRODUK *</label><input type="text" name="NamaProduk" id="editNama" required /></div>
            <div class="row2">
                <div class="field"><label>HARGA (Rp) *</label><input type="number" name="Harga" id="editHarga" min="0" required /></div>
                <div class="field"><label>STOK *</label><input type="number" name="Stok" id="editStok" min="0" required /></div>
            </div>
            <div class="field">
                <label>KATEGORI *</label>
                <select name="kategori" id="editKategori" required>
                    <option>Pakaian</option>
                    <option>Sepatu</option>
                    <option>Tas</option>
                    <option>Aksesoris</option>
                    <option>Elektronik</option>
                    <option>Lainnya</option>
                </select>
            </div>
            <div class="field"><label>DESKRIPSI</label><textarea name="deskripsi" id="editDeskripsi"></textarea></div>
            <button type="submit" class="btn-save">💾 Update Produk</button>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
const updateUrlTemplate = @json(route('admin.produk.update', ['id' => '__ID__']));

function bukaModal(id) { document.getElementById(id).classList.remove('hidden'); }
function tutupModal(id) { document.getElementById(id).classList.add('hidden'); }

function previewFoto(input, previewId, iconId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById(previewId).src = e.target.result;
            document.getElementById(previewId).classList.remove('hidden');
            document.getElementById(iconId).classList.add('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function bukaEdit(p) {
    document.getElementById('formEdit').action = updateUrlTemplate.replace('__ID__', p.ProdukID);
    document.getElementById('editNama').value = p.NamaProduk;
    document.getElementById('editHarga').value = p.Harga;
    document.getElementById('editStok').value = p.Stok;
    document.getElementById('editKategori').value = p.kategori;
    document.getElementById('editDeskripsi').value = p.deskripsi ?? '';

    const preview = document.getElementById('previewEdit');
    const uploadIcon = document.getElementById('uploadIconEdit');
    if (p.fotoUrl) {
        preview.src = p.fotoUrl;
        preview.classList.remove('hidden');
        uploadIcon.classList.add('hidden');
    } else {
        preview.src = '';
        preview.classList.add('hidden');
        uploadIcon.classList.remove('hidden');
    }
    bukaModal('modalEdit');
}

function bukaEditFromButton(button) {
    const p = {
        ProdukID: button.dataset.id,
        NamaProduk: button.dataset.nama,
        Harga: button.dataset.harga,
        Stok: button.dataset.stok,
        kategori: button.dataset.kategori,
        deskripsi: button.dataset.deskripsi,
        fotoUrl: button.dataset.fotoUrl || null,
    };

    bukaEdit(p);
}

// Tutup modal klik luar
document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', function(e) {
        if (e.target === this) this.classList.add('hidden');
    });
});
</script>
@endsection
