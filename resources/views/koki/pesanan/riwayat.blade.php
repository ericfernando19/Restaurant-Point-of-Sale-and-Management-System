@extends('layouts.app')

@section('content')
    <style>
        /* --- 🎨 Variabel Warna Dasar --- */
        :root {
            --base-color: #f0f0f3;
            --primary-color: #007bff;
            --accent-color: #28a745;
            /* Warna Hijau/Success untuk Riwayat Selesai */
            --text-color: #4a4a4a;
            --shadow-light: #ffffff;
            --shadow-dark: #d9d9dc;
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
            margin-bottom: 30px;
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

        .kode-transaksi {
            font-weight: 600;
            color: var(--primary-color);
        }

        .timestamp {
            font-size: 0.95rem;
            color: #6c757d;
        }

        .total-harga {
            font-weight: 700;
            color: var(--accent-color);
        }
    </style>

    <div class="container-fluid">
        <div class="data-card">
            <h3><i class="fas fa-history me-2"></i> Riwayat Pesanan Selesai</h3>

            <div class="table-responsive">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th>Kode Transaksi</th>
                            <th width="150" class="text-end">Total Harga</th>
                            <th width="180" class="text-center">Waktu Selesai</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($riwayat as $p)
                            <tr>
                                <td class="kode-transaksi">{{ $p->kode_transaksi }}</td>
                                <td class="text-end total-harga">Rp {{ number_format($p->total_harga) }}</td>
                                <td class="text-center timestamp">{{ $p->updated_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
