@extends('layouts.app')

@section('content')
    <style>
        /* --- 🎨 Variabel Warna Dasar --- */
        :root {
            --base-color: #f0f0f3;
            --primary-color: #007bff;
            --accent-color: #008cba;
            --text-color: #4a4a4a;
            --shadow-light: #ffffff;
            --shadow-dark: #d9d9dc;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
        }

        /* --- Main Layout Wrapper & Container --- */
        .container-fluid {
            padding: 20px 40px;
            background-color: var(--base-color);
        }

        /* --- Card Utama (Neumorphism) --- */
        .data-card {
            background-color: var(--base-color);
            border-radius: 20px;
            padding: 30px;
            box-shadow:
                10px 10px 20px var(--shadow-dark),
                -10px -10px 20px var(--shadow-light);
        }

        /* --- Judul Halaman --- */
        h3 {
            font-weight: 700;
            color: var(--accent-color);
            margin-bottom: 25px;
            display: flex;
            align-items: center;
        }

        /* --- Tabel Styling Modern --- */
        .table-modern {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            background-color: white;
        }

        .table-modern thead th {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
            padding: 15px 12px;
            border: none;
        }

        .table-modern tbody td {
            padding: 12px;
            color: var(--text-color);
            border-top: 1px solid #e0e0e0;
            vertical-align: middle;
        }

        .table-modern tbody tr:nth-child(even) {
            background-color: #f7f7f7;
        }

        /* --- Status Badge --- */
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: capitalize;
            box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
        }

        /* Warna Status */
        .status-menunggu {
            background-color: var(--primary-color);
            color: white;
        }

        .status-diproses {
            background-color: var(--warning-color);
            color: var(--text-color);
        }

        .status-selesai {
            background-color: var(--success-color);
            color: white;
        }

        /* --- Tombol Aksi --- */
        .btn-detail {
            background-color: var(--info-color);
            color: white;
            border-radius: 8px;
            font-weight: 500;
            transition: background-color 0.2s;
        }

        .btn-detail:hover {
            background-color: #138496;
            color: white;
        }
    </style>

    <div class="container-fluid">
        <div class="data-card">
            <h3><i class="fas fa-clipboard-list me-2"></i> Daftar Pesanan Masuk</h3>

            <div class="table-responsive">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th>Kode Transaksi</th>
                            <th width="150" class="text-end">Total Harga</th>
                            <th width="120" class="text-center">Status Dapur</th>
                            <th width="100" class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($pesanan as $p)
                            <tr>
                                <td>{{ $p->kode_transaksi }}</td>
                                <td class="text-end fw-bold">Rp {{ number_format($p->total_harga) }}</td>
                                <td class="text-center">
                                    {{-- Menggunakan badge modern berdasarkan status --}}
                                    <span class="status-badge status-{{ strtolower($p->status_koki) }}">
                                        {{ ucfirst($p->status_koki) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    {{-- Tombol Detail modern --}}
                                    <a href="{{ route('koki.pesanan.detail', $p->id) }}" class="btn btn-sm btn-detail">
                                        <i class="fas fa-info-circle me-1"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
