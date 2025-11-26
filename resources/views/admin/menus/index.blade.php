@extends('layouts.app')

@section('content')
<style>
    /* Variabel Warna dari Layout Utama */
    :root {
        --base-color: #f0f0f3;
        --accent-color: #008cba;
        --shadow-light: #ffffff;
        --shadow-dark: #d9d9dc;
        --text-color: #4a4a4a;
        --warning-color: #f39c12; /* Kuning untuk Edit */
        --danger-color: #e74c3c; /* Merah untuk Hapus */
        --success-color: #2ecc71; /* Hijau untuk Makanan */
        --info-color: #3498db; /* Biru untuk Minuman */
    }

    /* Card Wrapper (untuk tabel) */
    .data-card {
        background-color: var(--base-color);
        border-radius: 15px;
        box-shadow:
            6px 6px 12px var(--shadow-dark),
            -6px -6px 12px var(--shadow-light);
        border: none;
        padding: 25px;
    }

    /* Tombol Utama (Neumorphism) */
    .btn-neumorphism {
        border: none;
        border-radius: 12px;
        padding: 10px 20px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow:
            4px 4px 8px rgba(0, 0, 0, 0.2),
            -4px -4px 8px var(--shadow-light);
    }

    .btn-neumorphism-primary {
        background-color: var(--accent-color);
        color: white;
    }

    .btn-neumorphism-primary:hover {
        background-color: #007ba8;
        box-shadow: inset 2px 2px 5px rgba(0, 0, 0, 0.3),
                    inset -2px -2px 5px var(--shadow-light);
        color: white;
    }

    /* Table Styling Modern */
    .table {
        border-radius: 12px;
        overflow: hidden;
        margin-top: 15px;
    }

    .table thead th {
        background-color: var(--accent-color);
        color: white;
        font-weight: 600;
        border: none;
        padding: 15px;
    }

    .table tbody td {
        padding: 12px;
        border-top: 1px solid #eee;
    }

    .table tbody tr:nth-child(even) {
        background-color: rgba(0, 140, 186, 0.05); /* Garis selang-seling tipis */
    }

    .table tbody tr:hover {
        background-color: rgba(0, 140, 186, 0.1);
    }

    /* Badge Category Styling */
    .badge-makanan { background-color: var(--success-color) !important; padding: 8px 12px; border-radius: 15px; }
    .badge-minuman { background-color: var(--info-color) !important; padding: 8px 12px; border-radius: 15px; }

    /* Action Buttons in Table */
    .btn-table-action {
        border-radius: 8px;
        padding: 5px 10px;
        font-size: 0.85rem;
    }

    /* Form Controls & Modal */
    .form-control,
    .form-select {
        border-radius: 8px;
        box-shadow: inset 2px 2px 5px var(--shadow-dark),
                    inset -2px -2px 5px var(--shadow-light);
    }
    .modal-header-primary {
        background-color: var(--accent-color);
        color: white;
        border-radius: 15px 15px 0 0;
        border-bottom: none;
    }
    .modal-header-warning {
        background-color: var(--warning-color);
        color: white;
        border-radius: 15px 15px 0 0;
        border-bottom: none;
    }
    .modal-content {
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
</style>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-secondary"><i class="fas fa-utensils me-2"></i> Daftar Menu</h3>
        <button class="btn btn-neumorphism btn-neumorphism-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="fas fa-plus-circle"></i> Tambah Menu
        </button>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Tabel Daftar Menu --}}
    <div class="data-card">
        <div class="table-responsive">
            <table class="table table-hover align-middle text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Menu</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($menus as $menu)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-start fw-bold">{{ $menu->nama }}</td>
                            <td>
                                @php
                                    $kategoriClass = $menu->kategori == 'makanan' ? 'badge-makanan' : 'badge-minuman';
                                @endphp
                                <span class="badge {{ $kategoriClass }}">
                                    {{ ucfirst($menu->kategori) }}
                                </span>
                            </td>
                            <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                            <td>
                                @if ($menu->gambar)
                                    <img src="{{ asset('storage/' . $menu->gambar) }}" width="60" height="60" class="rounded shadow-sm" style="object-fit: cover;">
                                @else
                                    <span class="text-muted"><i class="fas fa-image"></i> -</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-warning btn-table-action text-white"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $menu->id }}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <form action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus menu {{ $menu->nama }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-table-action">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>

                        {{-- Modal Edit --}}
                        <div class="modal fade" id="editModal{{ $menu->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $menu->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header modal-header-warning">
                                        <h5 class="modal-title" id="editModalLabel{{ $menu->id }}"><i class="fas fa-edit"></i> Edit Menu</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('admin.menus.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Nama Menu</label>
                                                <input type="text" name="nama" value="{{ $menu->nama }}" class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Deskripsi</label>
                                                <textarea name="deskripsi" class="form-control" rows="3">{{ $menu->deskripsi }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Harga</label>
                                                <input type="number" name="harga" value="{{ $menu->harga }}" class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Kategori</label>
                                                <select name="kategori" class="form-select" required>
                                                    <option value="makanan" {{ $menu->kategori == 'makanan' ? 'selected' : '' }}>Makanan</option>
                                                    <option value="minuman" {{ $menu->kategori == 'minuman' ? 'selected' : '' }}>Minuman</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Gambar (opsional)</label>
                                                <input type="file" name="gambar" class="form-control">
                                                @if ($menu->gambar)
                                                    <small class="text-muted">Gambar saat ini:</small><br>
                                                    <img src="{{ asset('storage/' . $menu->gambar) }}" width="80" height="80" class="rounded mt-1 shadow-sm" style="object-fit: cover;">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="modal-footer" style="border-top: none;">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-warning text-white"><i class="fas fa-save"></i> Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="fas fa-info-circle me-2"></i> Belum ada menu yang terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Create --}}
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h5 class="modal-title" id="createModalLabel"><i class="fas fa-plus-square"></i> Tambah Menu Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.menus.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Menu</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" name="harga" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="makanan">Makanan</option>
                            <option value="minuman">Minuman</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gambar (opsional)</label>
                        <input type="file" name="gambar" class="form-control">
                        <small class="text-muted">Unggah gambar menu (JPG/PNG).</small>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: none;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
