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
            --success-color: #2ecc71;
            /* Hijau untuk pendapatan */
            --danger-color: #e74c3c;
            /* Merah untuk tombol cetak */
        }

        /* Style Judul */
        .page-header h3 {
            font-weight: 700;
            color: var(--accent-color);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        /* Form Controls (Input Tanggal) */
        .form-control {
            border-radius: 8px;
            border: 1px solid var(--shadow-dark);
            background-color: var(--base-color);
            box-shadow: inset 2px 2px 5px var(--shadow-dark),
                inset -2px -2px 5px var(--shadow-light);
            color: var(--text-color);
            padding: 10px 15px;
        }

        /* Tombol Neumorphism */
        .btn-neumorphism {
            border: none;
            border-radius: 12px;
            padding: 10px 15px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow:
                3px 3px 6px var(--shadow-dark),
                -3px -3px 6px var(--shadow-light);
        }

        .btn-neumorphism-primary {
            background-color: var(--accent-color);
            color: white;
        }

        .btn-neumorphism-danger {
            background-color: var(--danger-color);
            color: white;
        }

        .btn-neumorphism:hover {
            box-shadow: inset 2px 2px 5px var(--shadow-dark),
                inset -2px -2px 5px var(--shadow-light);
            color: white;
        }

        /* Ringkasan Data Card (Pengganti Alert) */
        .summary-card {
            background-color: var(--base-color);
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 25px;
            border-left: 5px solid var(--success-color);
            /* Aksen Hijau */
            box-shadow:
                6px 6px 12px var(--shadow-dark),
                -6px -6px 12px var(--shadow-light);
        }

        .summary-card strong {
            font-weight: 600;
            color: var(--text-color);
        }

        .summary-card .total-pendapatan {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--success-color);
            display: block;
            margin-top: 5px;
        }

        /* Table Styling Modern */
        .table-container {
            background-color: var(--base-color);
            border-radius: 15px;
            box-shadow:
                6px 6px 12px var(--shadow-dark),
                -6px -6px 12px var(--shadow-light);
            overflow: hidden;
        }

        .table-custom {
            width: 100%;
            margin-bottom: 0;
            border-collapse: separate;
        }

        .table-custom thead th {
            background-color: var(--accent-color);
            color: white;
            font-weight: 600;
            border: none;
            padding: 15px;
        }

        .table-custom tbody tr:nth-child(even) {
            background-color: rgba(0, 140, 186, 0.05);
        }

        .table-custom tbody tr:hover {
            background-color: rgba(0, 140, 186, 0.1);
        }

        .table-custom tbody tr td {
            padding: 12px 15px;
            border: none;
            color: var(--text-color);
        }

        .table-custom .kode-transaksi {
            font-weight: 600;
        }
    </style>

    <div class="page-header">
        <h3><i class="fas fa-chart-line me-2"></i> Laporan Transaksi</h3>
    </div>

    {{-- Filter dan Aksi --}}
    <div class="row mb-4 g-3 align-items-center">
        <form method="GET" class="row g-3 align-items-center">
            <div class="col-md-4">
                <input type="date" name="tanggal" class="form-control" value="{{ $tanggal }}">
            </div>
            <div class="col-md-2">
                <button class="btn btn-neumorphism btn-neumorphism-primary w-100">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </div>
            <div class="col-md-3 offset-md-3">
                <a href="{{ route('admin.laporan.cetak', ['tanggal' => $tanggal]) }}"
                    class="btn btn-neumorphism btn-neumorphism-danger w-100" target="_blank">
                    <i class="fas fa-print"></i> Cetak PDF
                </a>
            </div>
        </form>
    </div>

    {{-- Ringkasan Data (Mengganti Alert Info) --}}
    <div class="summary-card">
        <div class="row">
            <div class="col-md-6 border-end">
                <strong>Total Pendapatan pada {{ date('d F Y', strtotime($tanggal)) }}:</strong>
                <span class="total-pendapatan">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
            </div>
            <div class="col-md-6 d-flex align-items-center ps-4">
                <div>
                    <strong>Jumlah Transaksi:</strong>
                    <span class="fs-4 fw-bold text-primary">{{ $jumlahTransaksi }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Transaksi --}}
    <div class="table-container shadow-sm">
        <div class="table-responsive">
            <table class="table table-custom text-center align-middle">
                <thead>
                    <tr>
                        <th><i class="fas fa-hashtag"></i> Kode</th>
                        <th><i class="fas fa-money-check-alt"></i> Total</th>
                        <th><i class="fas fa-clock"></i> Tanggal & Waktu</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($transaksi as $t)
                        <tr>
                            <td class="kode-transaksi">{{ $t->kode_transaksi }}</td>
                            <td class="fw-bold text-success">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                            <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-muted text-center py-4">
                                <i class="fas fa-info-circle me-2"></i> Tidak ada data transaksi yang ditemukan pada tanggal
                                ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
