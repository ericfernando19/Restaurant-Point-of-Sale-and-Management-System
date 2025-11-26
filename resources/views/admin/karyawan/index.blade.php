@extends('layouts.app')

@section('content')
    <style>
        /* Menggunakan variabel warna dari layout sebelumnya */
        :root {
            --base-color: #f0f0f3;
            --accent-color: #008cba;
            --shadow-light: #ffffff;
            --shadow-dark: #d9d9dc;
            --text-color: #4a4a4a;
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
        }

        .btn-neumorphism-primary {
            background-color: var(--accent-color);
            color: white;
            box-shadow:
                4px 4px 8px rgba(0, 0, 0, 0.2),
                -4px -4px 8px var(--shadow-light);
        }

        .btn-neumorphism-primary:hover {
            background-color: #007ba8;
            /* Warna sedikit gelap saat hover */
            box-shadow: inset 2px 2px 5px rgba(0, 0, 0, 0.3),
                inset -2px -2px 5px var(--shadow-light);
            /* Efek tertekan */
            color: white;
        }

        /* Tombol Secondary (Filter/Reset) */
        .btn-neumorphism-secondary,
        .btn-neumorphism-outline {
            background-color: var(--base-color);
            color: var(--text-color);
            box-shadow:
                3px 3px 6px var(--shadow-dark),
                -3px -3px 6px var(--shadow-light);
        }

        .btn-neumorphism-secondary:hover,
        .btn-neumorphism-outline:hover {
            box-shadow: inset 2px 2px 5px var(--shadow-dark),
                inset -2px -2px 5px var(--shadow-light);
            color: var(--accent-color);
            background-color: var(--base-color);
        }

        /* Form Controls (Select & Input) */
        .form-control,
        .form-select {
            border-radius: 8px;
            border: 1px solid var(--shadow-dark);
            background-color: var(--base-color);
            box-shadow: inset 2px 2px 5px var(--shadow-dark),
                inset -2px -2px 5px var(--shadow-light);
            color: var(--text-color);
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
        }

        .table tbody tr:nth-child(even) {
            background-color: rgba(0, 140, 186, 0.05);
            /* Garis selang-seling tipis */
        }

        .table tbody tr:hover {
            background-color: rgba(0, 140, 186, 0.1);
        }

        /* Badge Role Styling */
        .badge {
            padding: 8px 12px;
            border-radius: 15px;
            font-weight: 600;
        }

        .badge-admin {
            background-color: #3498db !important;
        }

        .badge-kasir {
            background-color: #2ecc71 !important;
        }

        .badge-koki {
            background-color: #f39c12 !important;
        }

        /* Modal Header Styling */
        .modal-header-neumorphism {
            background-color: var(--accent-color);
            color: white;
            border-radius: 10px 10px 0 0;
            border-bottom: none;
        }

        /* Action Buttons in Table */
        .btn-table-action {
            border-radius: 8px;
            padding: 5px 10px;
            font-size: 0.85rem;
        }
    </style>

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-secondary"><i class="fas fa-users"></i> Daftar Karyawan</h3>
            <button class="btn btn-neumorphism btn-neumorphism-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="fas fa-plus-circle"></i> Tambah Karyawan
            </button>
        </div>

        {{-- Filter & Search --}}
        <div class="data-card mb-4 p-4">
            <form action="{{ route('admin.karyawan.index') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-md-3">
                    <select name="role" class="form-select" onchange="this.form.submit()">
                        <option value="">-- Semua Role --</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="kasir" {{ request('role') == 'kasir' ? 'selected' : '' }}>Kasir</option>
                        <option value="koki" {{ request('role') == 'koki' ? 'selected' : '' }}>Koki</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                        placeholder="Cari nama, email, atau telepon">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-neumorphism btn-neumorphism-secondary w-100">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.karyawan.index') }}" class="btn btn-neumorphism btn-neumorphism-outline w-100">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                </div>
            </form>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Tabel Daftar Karyawan --}}
        <div class="data-card">
            <div class="table-responsive">
                <table class="table table-hover text-center align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($karyawans as $karyawan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-start fw-bold">{{ $karyawan->nama }}</td>
                                <td>{{ $karyawan->email }}</td>
                                <td>{{ $karyawan->telepon ?? '-' }}</td>
                                <td>
                                    @php
                                        $roleClass = '';
                                        if ($karyawan->role == 'admin') {
                                            $roleClass = 'badge-admin';
                                        } elseif ($karyawan->role == 'kasir') {
                                            $roleClass = 'badge-kasir';
                                        } elseif ($karyawan->role == 'koki') {
                                            $roleClass = 'badge-koki';
                                        }
                                    @endphp
                                    <span class="badge {{ $roleClass }}">
                                        {{ ucfirst($karyawan->role) }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-table-action text-white" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $karyawan->id }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <form action="{{ route('admin.karyawan.destroy', $karyawan->id) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus karyawan {{ $karyawan->nama }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-table-action">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            {{-- Modal Edit (Dibiarkan tetap di sini sesuai logika Blade Anda) --}}
                            <div class="modal fade" id="editModal{{ $karyawan->id }}" tabindex="-1"
                                aria-labelledby="editModalLabel{{ $karyawan->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content" style="border-radius: 15px;">
                                        <div class="modal-header modal-header-neumorphism">
                                            <h5 class="modal-title" id="editModalLabel{{ $karyawan->id }}"><i
                                                    class="fas fa-edit"></i> Edit Karyawan</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('admin.karyawan.update', $karyawan->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Nama</label>
                                                    <input type="text" name="nama" class="form-control"
                                                        value="{{ $karyawan->nama }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" name="email" class="form-control"
                                                        value="{{ $karyawan->email }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Telepon</label>
                                                    <input type="text" name="telepon" class="form-control"
                                                        value="{{ $karyawan->telepon }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Role</label>
                                                    <select name="role" class="form-select" required>
                                                        <option value="admin"
                                                            {{ $karyawan->role == 'admin' ? 'selected' : '' }}>Admin
                                                        </option>
                                                        <option value="kasir"
                                                            {{ $karyawan->role == 'kasir' ? 'selected' : '' }}>Kasir
                                                        </option>
                                                        <option value="koki"
                                                            {{ $karyawan->role == 'koki' ? 'selected' : '' }}>Koki</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer" style="border-top: none;">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-warning text-white"><i
                                                        class="fas fa-save"></i> Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="6" class="text-muted text-center py-4">
                                    <i class="fas fa-info-circle me-2"></i> Belum ada data karyawan yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-3 d-flex justify-content-end">
                {{ $karyawans->withQueryString()->links() }}
            </div>
        </div>
    </div>

    {{-- Modal Create --}}
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 15px;">
                <div class="modal-header modal-header-neumorphism">
                    <h5 class="modal-title" id="createModalLabel"><i class="fas fa-user-plus"></i> Tambah Karyawan Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.karyawan.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Telepon</label>
                            <input type="text" name="telepon" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="admin">Admin</option>
                                <option value="kasir">Kasir</option>
                                <option value="koki">Koki</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                            <small class="text-muted">Password awal akan dibuat untuk login karyawan.</small>
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
