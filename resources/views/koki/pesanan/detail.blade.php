@extends('layouts.app')

@section('content')
    <style>
        /* --- 🎨 Variabel Warna Dasar --- */
        :root {
            --base-color: #f0f0f3;
            /* Latar belakang halaman */
            --accent-color: #ffc107;
            /* Warning color untuk Koki */
            --primary-color: #007bff;
            --text-color: #4a4a4a;
            --shadow-light: #ffffff;
            --shadow-dark: #d9d9dc;
            --success-color: #28a745;
        }

        /* --- Main Layout Wrapper & Container --- */
        .container-fluid {
            padding: 20px 40px;
            background-color: var(--base-color);
            min-height: calc(100vh - 56px);
            /* Memastikan background penuh */
        }

        /* --- Judul Halaman --- */
        h3 {
            font-weight: 700;
            color: var(--accent-color);
            margin-bottom: 30px;
            display: flex;
            align-items: center;
        }

        /* --- Informasi Status Transaksi (Tampilan modern tetap) --- */
        .status-info {
            background-color: white;
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            font-weight: 600;
            color: var(--text-color);
        }

        /* --- Tabel Styling Modern --- */
        .table-modern {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            /* Shadow Tabel */
            background-color: white;
            margin-bottom: 25px;
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

        .table-modern tfoot td {
            font-weight: 700;
            border-top: 2px solid var(--accent-color);
            font-size: 1.1rem;
        }

        /* --- Tombol Aksi Status --- */
        .btn-status-action {
            font-size: 1.2rem;
            padding: 15px;
            border-radius: 15px;
            font-weight: 600;
            transition: all 0.3s ease;
            /* Neumorphism/Shadow di tombol tetap dipertahankan */
            box-shadow:
                4px 4px 8px var(--shadow-dark),
                -4px -4px 8px var(--shadow-light);
            border: none;
        }

        .btn-status-action:hover {
            box-shadow: inset 3px 3px 6px var(--shadow-dark), inset -3px -3px 6px var(--shadow-light);
        }

        /* Warna Tombol Berdasarkan Status */
        .btn-start {
            background-color: var(--success-color);
            color: white;
        }

        .btn-finish {
            background-color: var(--accent-color);
            color: var(--text-color);
        }

        .alert-success-modern {
            background-color: #d4edda;
            color: var(--success-color);
            border-radius: 15px;
            padding: 15px;
            font-weight: 700;
            font-size: 1.1rem;
        }
    </style>

    <div class="container-fluid">
        <h3><i class="fas fa-receipt me-2"></i> Detail Pesanan — **{{ $pesanan->kode_transaksi }}**</h3>

        {{-- STATUS SAAT INI --}}
        <div class="status-info text-center">
            **Status Dapur:** @if ($pesanan->status_koki == 'pending')
                <span class="text-danger"><i class="fas fa-hourglass-start me-1"></i> MENUNGGU</span>
            @elseif($pesanan->status_koki == 'diproses')
                <span class="text-warning"><i class="fas fa-fire-alt me-1"></i> SEDANG DIPROSES</span>
            @elseif($pesanan->status_koki == 'selesai_koki')
                <span class="text-success"><i class="fas fa-check-circle me-1"></i> SELESAI</span>
            @endif
        </div>

        <div class="table-responsive">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th>Menu Pesanan</th>
                        <th width="80" class="text-center">Qty</th>
                        <th width="150" class="text-end">Subtotal</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($pesanan->details as $d)
                        <tr>
                            <td class="fw-bold">{{ $d->menu->nama }}</td>
                            <td class="text-center">{{ $d->qty }}</td>
                            <td class="text-end">Rp {{ number_format($d->subtotal) }}</td>
                        </tr>
                    @endforeach
                </tbody>

                {{-- Tambahkan Total Harga di Footer Tabel --}}
                <tfoot>
                    <tr>
                        <td colspan="2" class="text-end">TOTAL HARGA:</td>
                        <td class="text-end text-danger">Rp {{ number_format($pesanan->total_harga) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- BUTTON PERUBAHAN STATUS --}}
        @if ($pesanan->status_koki !== 'selesai_koki')
            <form method="POST" action="{{ route('koki.pesanan.status', $pesanan->id) }}">
                @csrf

                <button
                    class="btn btn-status-action w-100 mt-3
                    @if ($pesanan->status_koki == 'pending') btn-start
                    @elseif($pesanan->status_koki == 'diproses')
                        btn-finish @endif
                    ">
                    <i
                        class="fas
                        @if ($pesanan->status_koki == 'pending') fa-play-circle
                        @elseif($pesanan->status_koki == 'diproses')
                            fa-check-double @endif
                        me-2"></i>
                    @if ($pesanan->status_koki == 'pending')
                        Mulai Proses
                    @elseif($pesanan->status_koki == 'diproses')
                        Tandai Selesai & Siap Diantar
                    @endif
                </button>
            </form>
        @else
            <div class="alert-success-modern mt-3 text-center">
                <i class="fas fa-check-circle me-2"></i> Pesanan sudah selesai dimasak!
            </div>
        @endif
    </div>
@endsection
