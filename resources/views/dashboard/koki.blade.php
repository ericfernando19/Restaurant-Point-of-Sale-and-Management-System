@extends('layouts.app')

@section('content')
    <style>
        /* --- 🎨 Variabel Warna Dasar (Disesuaikan untuk Tampilan Modern) --- */
        :root {
            --base-color: #f0f0f3;
            /* Latar Belakang Dasar */
            --primary-color: #007bff;
            /* Biru/Primary untuk link/judul */
            --text-color: #4a4a4a;
            /* Warna Teks Umum */
            --shadow-light: #ffffff;
            --shadow-dark: #d9d9dc;
            --info-light: #d1ecf1;
            /* Warna untuk Alert Info */
            --info-dark: #00768c;
            /* Warna Teks Alert Info */
        }

        /* --- Main Layout Wrapper --- */
        .page-wrapper {
            padding: 30px 20px;
        }

        /* --- Judul Dashboard --- */
        .dashboard-title {
            font-weight: 800;
            color: var(--primary-color);
            margin-bottom: 30px;
            display: flex;
            align-items: center;
        }

        /* --- Alert Modern --- */
        .alert-modern {
            background-color: var(--info-light);
            color: var(--info-dark);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 40px;
            border: 1px solid #b8daff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        /* --- Card Neumorphism untuk Statistik --- */
        .stat-card {
            background-color: var(--base-color);
            border-radius: 20px;
            padding: 25px;
            border: none;
            text-align: center;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;

            /* Efek Neumorphism */
            box-shadow:
                8px 8px 16px var(--shadow-dark),
                -8px -8px 16px var(--shadow-light);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stat-card:hover {
            /* Efek sedikit terangkat saat di-hover */
            transform: translateY(-3px);
            box-shadow:
                10px 10px 20px var(--shadow-dark),
                -10px -10px 20px var(--shadow-light);
        }

        .stat-card h4 {
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 15px;
        }

        .stat-card h2 {
            font-size: 3.5rem;
            font-weight: 900;
            margin-bottom: 20px;
            /* Warna angka disesuaikan dengan status */
        }

        /* Warna Khusus untuk Angka */
        .stat-card.menunggu h2 {
            color: var(--primary-color);
        }

        .stat-card.diproses h2 {
            color: #ffc107;
            /* Kuning/Warning */
        }

        .stat-card.selesai h2 {
            color: #28a745;
            /* Hijau/Success */
        }

        /* --- Tombol Aksi Neumorphism --- */
        .btn-stat {
            font-weight: 600;
            border-radius: 15px;
            padding: 10px 15px;
            box-shadow: 3px 3px 6px var(--shadow-dark), -3px -3px 6px var(--shadow-light);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-stat:hover {
            /* Efek inset saat di-hover */
            box-shadow: inset 3px 3px 6px var(--shadow-dark), inset -3px -3px 6px var(--shadow-light);
        }

        /* Warna Tombol */
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-warning {
            background-color: #ffc107;
            color: var(--text-color);
        }

        .btn-success {
            background-color: #28a745;
            color: white;
        }

        /* Override Bootstrap shadow/border pada card */
        .card {
            border: none;
        }
    </style>

    <div class="page-wrapper container">
        <h2 class="dashboard-title"><i class="fas fa-utensils me-3"></i> Dashboard Koki</h2>

        <div class="alert-modern">
            <h5 style="color: var(--info-dark);">
                <i class="fas fa-concierge-bell me-2"></i> Selamat datang, **{{ Auth::user()->name }}**!
            </h5>
            Berikut adalah ringkasan aktivitas pesanan di dapur hari ini.
        </div>

        <div class="row g-4">

            <div class="col-md-4">
                <div class="stat-card menunggu">
                    <div>
                        <h4>🕒 Menunggu Diproses</h4>
                        <h2>{{ $menunggu }}</h2>
                    </div>
                    <a href="{{ route('koki.pesanan') }}" class="btn btn-stat btn-primary w-100 mt-3">
                        <i class="fas fa-list-alt me-1"></i> Lihat Pesanan Baru
                    </a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card diproses">
                    <div>
                        <h4>🔥 Sedang Dimasak</h4>
                        <h2>{{ $diproses }}</h2>
                    </div>
                    <a href="{{ route('koki.pesanan') }}" class="btn btn-stat btn-warning w-100 mt-3">
                        <i class="fas fa-fire-alt me-1"></i> Lanjutkan Memasak
                    </a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card selesai">
                    <div>
                        <h4>✅ Selesai Hari Ini</h4>
                        <h2>{{ $selesai }}</h2>
                    </div>
                    <a href="{{ route('koki.riwayat') }}" class="btn btn-stat btn-success w-100 mt-3">
                        <i class="fas fa-history me-1"></i> Lihat Riwayat Selesai
                    </a>
                </div>
            </div>

        </div>
    </div>
@endsection
