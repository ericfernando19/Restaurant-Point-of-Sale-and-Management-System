@extends('layouts.app')

@section('content')
    <style>
        /* Variabel Warna (Konsisten dengan Riwayat Transaksi) */
        :root {
            --base-color: #f0f0f3;
            --accent-color: #008cba;
            --shadow-light: #ffffff;
            --shadow-dark: #d9d9dc;
            --text-color: #4a4a4a;
            --info-color: #3498db;
        }

        /* --- Card Utama (Neumorphism) --- */
        .data-card {
            background-color: var(--base-color);
            border-radius: 20px;
            padding: 30px;
            border: none;
            box-shadow:
                8px 8px 16px var(--shadow-dark),
                -8px -8px 16px var(--shadow-light);
        }

        .data-card h3 {
            font-weight: 700;
            color: var(--accent-color);
            margin-bottom: 25px;
            display: flex;
            align-items: center;
        }

        /* --- Container Tabel Clean --- */
        .table-container {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            background-color: white;
        }

        /* --- Tabel Styling Modern --- */
        .table-modern {
            width: 100%;
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-modern thead th {
            background-color: var(--accent-color);
            color: white;
            font-weight: 600;
            border: none;
            padding: 15px;
            vertical-align: middle;
        }

        .table-modern tbody tr {
            transition: background-color 0.2s;
        }

        .table-modern tbody tr:nth-child(even) {
            background-color: rgba(0, 140, 186, 0.05);
            /* Striped row */
        }

        .table-modern tbody tr:hover {
            background-color: rgba(0, 140, 186, 0.1) !important;
        }

        .table-modern tbody td {
            padding: 12px 15px;
            color: var(--text-color);
            border-top: 1px solid #e0e0e0;
            vertical-align: middle;
        }

        .total-col {
            font-weight: 700;
            color: #e67e22;
            /* Warna yang berbeda untuk total agar menonjol */
        }

        /* --- Tombol Aksi --- */
        .btn-action-primary {
            background-color: var(--info-color);
            /* Biru terang untuk aksi */
            color: white;
            border: none;
            border-radius: 8px;
            padding: 6px 12px;
            font-size: 0.85rem;
            transition: background-color 0.2s;
        }

        .btn-action-primary:hover {
            background-color: #2980b9;
            color: white;
        }
    </style>

    {{-- Menggunakan container-fluid dengan padding untuk menghindari tumpang tindih dengan Sidebar --}}
    <div class="container-fluid py-4 ps-4 pe-4">
        <div class="data-card">
            <h3 class="mb-4"><i class="fas fa-clipboard-list me-2"></i> Daftar Pembayaran</h3>

            {{-- CONTAINER TABEL --}}
            <div class="table-container">
                <div class="table-responsive">
                    <table class="table table-modern align-middle">
                        <thead>
                            <tr>
                                <th width="150">Kode</th>
                                <th width="150">Total</th>
                                <th width="200">Tanggal</th>
                                <th width="100">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($transaksi as $trx)
                                <tr>
                                    <td class="fw-bold">{{ $trx->kode_transaksi }}</td>
                                    <td class="total-col">Rp {{ number_format($trx->total_harga) }}</td>
                                    <td>{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('kasir.pembayaran.show', $trx->id) }}"
                                            class="btn btn-action-primary btn-sm">
                                            <i class="fas fa-money-bill-wave me-1"></i> Bayar
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- END CONTAINER TABEL --}}
        </div>
    </div>
@endsection
