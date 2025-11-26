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

        /* Styling Judul dan Deskripsi */
        .dashboard-header h2 {
            font-weight: 700;
            color: var(--accent-color);
            margin-bottom: 5px;
        }

        .dashboard-header p {
            color: #888;
            font-weight: 400;
        }

        /* Card Modern (Neumorphism) */
        .info-card {
            background-color: var(--base-color);
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            border: none;
            /* Efek timbul Neumorphism pada card */
            box-shadow:
                6px 6px 12px var(--shadow-dark),
                -6px -6px 12px var(--shadow-light);
            transition: all 0.3s ease;
            height: 100%;
        }

        .info-card:hover {
            /* Efek hover 'terangkat' sedikit */
            box-shadow: 8px 8px 15px var(--shadow-dark),
                -8px -8px 15px var(--shadow-light);
        }

        /* Styling Angka Utama */
        .info-card h2 {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--accent-color);
            /* Menonjolkan angka dengan warna aksen */
            margin-top: 10px;
            margin-bottom: 5px;
        }

        /* Styling Judul Card */
        .info-card h5 {
            font-weight: 600;
            color: var(--text-color);
            display: flex;
            align-items: center;
        }

        /* Styling Ikon di Card */
        .info-card h5 i {
            margin-right: 10px;
            font-size: 1.2rem;
            color: var(--accent-color);
        }

        /* Styling Keterangan Kecil */
        .info-card small {
            color: #a0a0a0;
            font-weight: 400;
        }
    </style>

    <div class="dashboard-header">
        <h2><i class="fas fa-tachometer-alt"></i> Dashboard Admin</h2>
        <p>Ringkasan performa dan aktivitas utama restoran Anda.</p>
    </div>

    <div class="row mt-5">

        {{-- Card 1: Total Menu --}}
        <div class="col-md-4">
            <div class="info-card">
                <h5><i class="fas fa-utensils"></i> Total Menu</h5>
                <h2>{{ $totalMenu }}</h2>
                <small>Jumlah menu yang terdaftar saat ini</small>
            </div>
        </div>

        {{-- Card 2: Total Karyawan --}}
        <div class="col-md-4">
            <div class="info-card">
                <h5><i class="fas fa-users"></i> Total Karyawan</h5>
                <h2>{{ $totalKaryawan }}</h2>
                <small>Jumlah Kasir & Koki aktif</small>
            </div>
        </div>

        {{-- Card 3: Transaksi Hari Ini --}}
        <div class="col-md-4">
            <div class="info-card">
                <h5><i class="fas fa-receipt"></i> Transaksi Hari Ini</h5>
                <h2>{{ $transaksiHariIni }}</h2>
                <small>Order yang masuk dan selesai hari ini</small>
            </div>
        </div>

    </div>

    <div class="row mt-4">

        {{-- Card 4: Pendapatan Hari Ini (Lebih Besar) --}}
        <div class="col-md-6">
            <div class="info-card">
                <h5><i class="fas fa-money-bill-wave"></i> Pendapatan Hari Ini</h5>
                <h2 class="text-success">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</h2>
                <small>Total omset bersih per hari</small>
            </div>
        </div>

        {{-- Card 5: Transaksi Bulan Ini (Lebih Besar) --}}
        <div class="col-md-6">
            <div class="info-card">
                <h5><i class="fas fa-calendar-alt"></i> Transaksi Bulan Ini</h5>
                <h2>{{ $transaksiBulanIni }}</h2>
                <small>Total seluruh transaksi bulan berjalan</small>
            </div>
        </div>

    </div>
@endsection
