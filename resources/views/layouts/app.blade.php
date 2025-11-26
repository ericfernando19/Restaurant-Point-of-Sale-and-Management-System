<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sistem Kasir Restoran</title>

    {{-- Font & Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <style>
        /* Variabel Warna Modern */
        :root {
            --base-color: #f0f0f3;
            /* Latar belakang lembut */
            --accent-color: #008cba;
            /* Biru Laut/Teal (Aksen Kuat) */
            --shadow-light: #ffffff;
            --shadow-dark: #d9d9dc;
            --text-color: #4a4a4a;
            --sidebar-width: 250px;
            /* Diperlebar sedikit agar lebih nyaman */
            --danger-color: #e74c3c;
        }

        body {
            /* Hapus display: flex pada body agar tidak mengganggu layout utama */
            background: var(--base-color);
            font-family: 'Inter', sans-serif;
            color: var(--text-color);
            min-height: 100vh;
        }

        /* --- Perbaikan Struktur Layout Utama --- */

        /* Container utama agar konten tidak terlalu lebar */
        .app-wrapper {
            display: flex;
            /* Menggunakan flex untuk memisahkan sidebar dan konten */
            min-height: 100vh;
        }

        /* --- Sidebar Styling (Fixed & Neumorphism) --- */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--base-color);
            padding: 30px 20px 20px;
            /* Efek timbul lembut */
            box-shadow:
                4px 4px 8px var(--shadow-dark),
                -4px -4px 8px var(--shadow-light);

            /* PENGATURAN POSISI TETAP DI KIRI */
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            display: flex;
            flex-direction: column;
        }

        .sidebar h4 {
            color: var(--accent-color);
            margin-bottom: 40px;
            font-weight: 700;
            text-align: center;
        }

        .sidebar-menu {
            flex-grow: 1;
        }

        .sidebar-menu a {
            color: var(--text-color);
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 12px 15px;
            margin: 8px 0;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        /* Hover Effect: Membuat tombol terlihat 'masuk' */
        .sidebar-menu a:hover {
            box-shadow: inset 2px 2px 5px var(--shadow-dark),
                inset -2px -2px 5px var(--shadow-light);
            color: var(--accent-color);
            background: var(--base-color);
        }

        /* Active Effect: Tombol yang sedang aktif */
        .sidebar-menu a.active {
            color: var(--shadow-light);
            background-color: var(--accent-color);
            font-weight: 600;
            box-shadow:
                4px 4px 8px rgba(0, 0, 0, 0.2),
                -4px -4px 8px var(--shadow-light);
        }

        .sidebar-menu a i {
            margin-right: 12px;
            font-size: 1.1rem;
        }

        /* Logout Button Styling */
        .sidebar .logout-section {
            padding: 20px 0 0;
            border-top: 1px solid var(--shadow-dark);
        }

        .sidebar .logout-section .btn-danger {
            background-color: var(--danger-color);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            transition: background-color 0.2s;
        }

        .sidebar .logout-section .btn-danger:hover {
            background-color: #c0392b;
        }

        /* --- Content Styling --- */
        .content-wrapper {
            flex-grow: 1;
            /* Konten mengambil sisa ruang */
            margin-left: var(--sidebar-width);
            /* Jarak agar konten tidak tertutup sidebar */
            padding: 30px;
        }

        .navbar-header {
            background-color: var(--base-color);
            padding: 20px 30px;
            margin-bottom: 30px;
            border-radius: 15px;
            box-shadow:
                6px 6px 12px var(--shadow-dark),
                -6px -6px 12px var(--shadow-light);
            color: var(--text-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-header h5 {
            font-weight: 600;
            color: var(--text-color);
            margin: 0;
        }

        .navbar-header .badge {
            font-size: 0.85rem;
            padding: 8px 15px;
            background-color: var(--accent-color) !important;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="app-wrapper">

        {{-- Sidebar (FIXED LEFT) --}}
        <div class="sidebar">
            <h4 class="text-center">🍴 RESTO POS</h4>

            <div class="sidebar-menu">
                @php
                    // Tentukan rute dashboard berdasarkan role dan path aktif
                    $dashboardRoute = '';
                    $activePath = '';
                    if (Auth::check()) {
                        $role = Auth::user()->role;
                        if ($role === 'admin') {
                            $dashboardRoute = route('admin.dashboard');
                            $activePath = 'admin/dashboard';
                        } elseif ($role === 'kasir') {
                            $dashboardRoute = route('kasir.dashboard');
                            $activePath = 'kasir/dashboard';
                        } elseif ($role === 'koki') {
                            $dashboardRoute = route('koki.dashboard');
                            $activePath = 'koki/dashboard';
                        }
                    }
                @endphp

                <a href="{{ $dashboardRoute }}"
                    class="{{ request()->is($activePath) || request()->is(explode('/', $activePath)[0] . '/dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i> Dashboard
                </a>

                {{-- Role-Based Menu Items --}}
                @if (Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ route('admin.menus.index') }}"
                        class="{{ request()->is('admin/menus*') ? 'active' : '' }}">
                        <i class="fas fa-utensils"></i> Manajemen Menu
                    </a>
                    <a href="{{ route('admin.karyawan.index') }}"
                        class="{{ request()->is('admin/karyawan*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i> Karyawan
                    </a>
                    <a href="{{ route('admin.laporan') }}"
                        class="{{ request()->is('admin/laporan*') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i> Laporan
                    </a>
                @elseif (Auth::check() && Auth::user()->role === 'kasir')
                    <a href="{{ route('kasir.transaksi.index') }}"
                        class="{{ request()->is('kasir/transaksi*') ? 'active' : '' }}">
                        <i class="fas fa-receipt"></i> Transaksi
                    </a>
                    {{-- Pastikan rute pembayaran disesuaikan dengan prefix kasir jika ada --}}
                    <a href="{{ route('kasir.pembayaran.index') }}"
                        class="{{ request()->is('kasir/pembayaran*') ? 'active' : '' }}">
                        <i class="fas fa-cash-register"></i> Pembayaran
                    </a>
                @elseif (Auth::check() && Auth::user()->role === 'koki')
                    <a href="{{ route('koki.pesanan') }}"
                        class="{{ request()->is('koki/pesanan*') ? 'active' : '' }}">
                        <i class="fas fa-fire-alt"></i> Pesanan Dapur
                    </a>
                    <a href="{{ route('koki.riwayat') }}"
                        class="{{ request()->is('koki/riwayat*') ? 'active' : '' }}">
                        <i class="fas fa-history"></i> Riwayat Pesanan
                    </a>
                @endif
            </div>

            <div class="logout-section">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="fas fa-sign-out-alt me-1"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
        {{-- END Sidebar --}}

        {{-- Content Wrapper (MAIN CONTENT AREA) --}}
        <div class="content-wrapper">
            <div class="navbar-header">
                <h5 class="m-0">Selamat Datang, {{ Auth::check() ? Auth::user()->name : 'Tamu' }}</h5>
                <span class="badge rounded-pill">{{ Auth::check() ? ucfirst(Auth::user()->role) : 'Guest' }}</span>
            </div>

            @yield('content')
        </div>
        {{-- END Content Wrapper --}}

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')

</body>

</html>
