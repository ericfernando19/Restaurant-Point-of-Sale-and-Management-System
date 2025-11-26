@extends('layouts.app')

@section('content')
    <style>
        /* Variabel Warna dari Layout Utama */
        :root {
            --base-color: #f0f0f3;
            --accent-color: #008cba;
            /* Biru */
            --shadow-light: #ffffff;
            --shadow-dark: #d9d9dc;
            --text-color: #4a4a4a;
            --success-color: #2ecc71;
            /* Hijau untuk Pemasukan */
            --info-color: #3498db;
            /* Biru untuk Transaksi */
        }

        /* Style Judul */
        .dashboard-header {
            font-weight: 700;
            color: var(--accent-color);
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            font-size: 1.8rem;
        }

        /* Dashboard Info Card (Neumorphism) */
        .info-card {
            background-color: var(--base-color);
            border-radius: 20px;
            padding: 25px;
            border: none;
            transition: all 0.3s ease;
            min-height: 150px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            box-shadow:
                8px 8px 16px var(--shadow-dark),
                -8px -8px 16px var(--shadow-light);
        }

        .info-card:hover {
            box-shadow:
                4px 4px 8px var(--shadow-dark),
                -4px -4px 8px var(--shadow-light);
        }

        .info-card h5 {
            font-weight: 500;
            color: var(--text-color);
            font-size: 1rem;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .info-card h3 {
            font-weight: 800;
            font-size: 2rem;
            margin: 0;
        }

        /* Spesific Color Tints */
        /* Pemasukan Hari Ini (Primary/Accent) */
        .card-primary h3 {
            color: var(--success-color);
        }

        .card-primary .icon-circle {
            background-color: rgba(46, 204, 113, 0.1);
            /* Latar belakang ikon hijau muda */
            color: var(--success-color);
        }

        /* Pemasukan Bulan Ini (Success/Success) */
        .card-success h3 {
            color: var(--accent-color);
        }

        .card-success .icon-circle {
            background-color: rgba(0, 140, 186, 0.1);
            /* Latar belakang ikon biru muda */
            color: var(--accent-color);
        }

        /* Jumlah Transaksi (Info/Info) */
        .card-info h3 {
            color: var(--warning-color);
            /* Menggunakan warna oranye/kuning untuk kontras */
        }

        .card-info .icon-circle {
            background-color: rgba(243, 156, 18, 0.1);
            /* Latar belakang ikon oranye muda */
            color: var(--warning-color);
        }

        .icon-circle {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            margin-right: 10px;
            font-size: 1.1rem;
        }
    </style>

    <div class="container py-4">
        <div class="dashboard-header">
            <i class="fas fa-cash-register me-3"></i> Dashboard Kasir
        </div>

        <div class="row g-4">
            {{-- Card: Pemasukan Hari Ini --}}
            <div class="col-md-4">
                <div class="info-card card-primary">
                    <h5>
                        <span class="icon-circle"><i class="fas fa-sun"></i></span>
                        Pemasukan Hari Ini
                    </h5>
                    <h3>Rp {{ number_format($hariIni, 0, ',', '.') }}</h3>
                </div>
            </div>

            {{-- Card: Pemasukan Bulan Ini --}}
            <div class="col-md-4">
                <div class="info-card card-success">
                    <h5>
                        <span class="icon-circle"><i class="fas fa-calendar-alt"></i></span>
                        Pemasukan Bulan Ini
                    </h5>
                    <h3>Rp {{ number_format($bulanIni, 0, ',', '.') }}</h3>
                </div>
            </div>

            {{-- Card: Jumlah Transaksi --}}
            <div class="col-md-4">
                <div class="info-card card-info">
                    <h5>
                        <span class="icon-circle"><i class="fas fa-receipt"></i></span>
                        Jumlah Transaksi
                    </h5>
                    <h3>{{ $totalTransaksi }}</h3>
                </div>
            </div>
        </div>
    </div>
@endsection
