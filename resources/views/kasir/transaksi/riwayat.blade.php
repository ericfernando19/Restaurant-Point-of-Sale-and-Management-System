@extends('layouts.app')

@section('content')
    <style>
        /* --- Variabel Layout & Warna (Agar sinkron dengan layout utama) --- */
        :root {
            /* Warna yang sama dengan layout utama */
            --primary-color: #008cba;
            --base-color: #f0f0f3;
            --shadow-light: #ffffff;
            --shadow-dark: #d9d9dc;
            --text-color: #4a4a4a;
            --danger-color: #e74c3c;
        }

        /* --- Main Card Styling (Neumorphism) --- */
        .card-neumorphism {
            border: none;
            border-radius: 20px;
            padding: 30px;
            background-color: var(--base-color);
            box-shadow: 10px 10px 20px var(--shadow-dark),
                -10px -10px 20px var(--shadow-light);
            transition: all 0.3s ease;
        }

        /* --- Header / Title --- */
        .card-neumorphism h3 {
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-neumorphism h3 i {
            font-size: 1.5rem;
        }

        /* --- Filter Form (Cleaned Up Neumorphism) --- */
        .form-control-neumorphism {
            border: none;
            background: var(--base-color);
            padding: 12px 15px;
            border-radius: 10px;
            color: var(--text-color);
            box-shadow: inset 3px 3px 6px var(--shadow-dark),
                inset -3px -3px 6px var(--shadow-light);
            transition: all 0.3s ease;
        }

        .form-control-neumorphism:focus {
            box-shadow: inset 1px 1px 3px var(--shadow-dark),
                inset -1px -1px 3px var(--shadow-light),
                0 0 0 0.25rem rgba(0, 140, 186, 0.2);
            /* Ring fokus lembut */
            background: var(--base-color);
            outline: none;
        }

        .btn-filter-neumorphism {
            font-weight: 600;
            border-radius: 10px;
            color: white;
            background-color: var(--primary-color);
            border: none;
            padding: 12px 20px;
            box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.2);
            transition: all 0.2s ease;
        }

        .btn-filter-neumorphism:hover {
            background-color: #007a9b;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
            transform: translateY(-1px);
        }

        /* --- Table Styling Modern & Neumorphism --- */
        .table-responsive {
            margin-top: 20px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 5px 5px 15px var(--shadow-dark),
                -5px -5px 15px var(--shadow-light);
        }

        .table-neumorphism {
            margin-bottom: 0;
            border-collapse: collapse;
            /* Penting untuk tampilan tabel bersih */
            background-color: white;
        }

        /* Table Header */
        .table-neumorphism thead th {
            background-color: var(--primary-color) !important;
            color: white;
            font-weight: 600;
            padding: 15px 12px;
            border-bottom: none;
            text-align: left;
        }

        /* Table Body */
        .table-neumorphism tbody tr {
            border-bottom: 1px solid #e0e0e0;
            transition: background-color 0.3s;
        }

        .table-neumorphism tbody tr:last-child {
            border-bottom: none;
        }

        .table-neumorphism tbody tr:hover {
            background-color: #e9f5f9;
            /* Hover lembut */
        }

        .table-neumorphism tbody td {
            vertical-align: middle;
            padding: 12px;
            color: var(--text-color);
        }

        /* Button Aksi (Lihat) */
        .btn-lihat-neumorphism {
            border-radius: 8px;
            font-weight: 500;
            background-color: #17a2b8;
            /* Info color */
            border: none;
            color: white;
            transition: all 0.2s ease;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .btn-lihat-neumorphism:hover {
            background-color: #138496;
            transform: translateY(-1px);
        }

        /* --- Pagination (Agar terlihat neumorphism) --- */
        .pagination-neumorphism {
            margin-top: 25px;
        }

        .pagination-neumorphism .page-link {
            border-radius: 8px;
            margin: 0 4px;
            border: none;
            background-color: var(--base-color);
            color: var(--text-color);
            box-shadow: 3px 3px 6px var(--shadow-dark), -3px -3px 6px var(--shadow-light);
            transition: all 0.3s ease;
        }

        .pagination-neumorphism .page-item.active .page-link {
            background-color: var(--primary-color) !important;
            color: white;
            box-shadow: inset 2px 2px 5px var(--shadow-dark), inset -2px -2px 5px var(--shadow-light);
        }

        .pagination-neumorphism .page-link:hover {
            color: var(--primary-color);
            box-shadow: inset 1px 1px 3px var(--shadow-dark), inset -1px -1px 3px var(--shadow-light);
        }

        /* --- Modal Struk Styling (Disesuaikan) --- */
        #riwayatStrukModal .modal-content {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 10px 10px 20px var(--shadow-dark);
            background-color: var(--base-color);
        }

        #riwayatStrukModal .modal-header {
            background-color: var(--primary-color) !important;
            color: white;
            border-bottom: none;
            padding: 15px 20px;
        }

        #riwayatStrukModal .modal-title {
            font-weight: 700;
        }

        #riwayatStrukModal .modal-body {
            padding: 30px;
            background-color: white;
        }

        #riwayatStrukModal .modal-body p {
            margin-bottom: 12px;
            padding-bottom: 5px;
            font-size: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        #riwayatStrukModal .modal-body strong {
            font-weight: 600;
        }

        #riwayatStrukModal .modal-footer {
            border-top: none;
            padding: 15px 30px;
            background-color: white;
        }

        #btnCetakRiwayat {
            border-radius: 10px;
            font-size: 1.0rem;
            font-weight: 700;
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            transition: background-color 0.2s;
        }

        /* Tambahkan kelas agar total/kembalian menonjol di modal */
        .text-strong-success {
            color: #28a745 !important;
            font-weight: 700;
        }

        .text-strong-primary {
            color: var(--primary-color) !important;
            font-weight: 700;
        }
    </style>

    {{-- Mengganti card lama dengan card-neumorphism --}}
    <div class="card-neumorphism">
        <div>
            <h3><i class="fas fa-history"></i> Riwayat Transaksi</h3>

            {{-- Filter Tanggal --}}
            <form method="GET" class="row g-3 mb-4 align-items-end">
                <div class="col-md-4 col-sm-6">
                    <label class="form-label fw-bold" for="tanggalFilter">Pilih Tanggal</label>
                    <input type="date" id="tanggalFilter" name="tanggal" class="form-control form-control-neumorphism"
                        value="{{ request('tanggal') }}">
                </div>
                {{-- Ukuran kolom filter tetap, hanya menyesuaikan padding --}}
                <div class="col-md-2 col-sm-6">
                    <button class="btn btn-primary w-100 btn-filter-neumorphism">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </form>

            {{-- Table Riwayat --}}
            <div class="table-responsive">
                <table class="table table-striped table-hover table-neumorphism">
                    <thead>
                        <tr>
                            <th width="70">ID</th>
                            <th width="150">Total</th>
                            <th width="180">Tanggal</th>
                            <th width="100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableRiwayat">
                        @foreach ($riwayat as $t)
                            <tr>
                                <td>{{ $t->id }}</td>
                                <td>Rp {{ number_format($t->total_harga) }}</td>
                                <td>{{ $t->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm btnLihatStruk btn-lihat-neumorphism"
                                        data-id="{{ $t->id }}">
                                        <i class="fa fa-receipt"></i> Lihat
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex flex-column text-center mt-3">
                <p>{{ $riwayat->firstItem() }} - {{ $riwayat->lastItem() }} dari {{ $riwayat->total() }} hasil</p>
                <div class="d-flex justify-content-center">
                    {{ $riwayat->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection


{{-- ====================== MODAL STRUK (Menggunakan kelas Bootstrap 5 dan Neumorphism) ====================== --}}
<div class="modal fade" id="riwayatStrukModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content shadow">

            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">
                    <i class="fa fa-receipt"></i> Detail Struk Transaksi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="riwayatStrukContent">
                <!-- AJAX Content Here -->
                <p class="text-muted text-center">Memuat detail struk...</p>
            </div>

            <div class="modal-footer">
                <a id="btnCetakRiwayat" href="#" target="_blank" class="btn btn-primary w-100">
                    <i class="fa fa-print"></i> Cetak PDF
                </a>
            </div>

        </div>
    </div>
</div>


{{-- ====================== AJX (Logika Pengambilan Data Diperbaiki agar sesuai styling modal baru) ====================== --}}
@section('scripts')
    <script>
        document.addEventListener("click", function(e) {

            // Menargetkan tombol Lihat Struk
            const btnLihatStruk = e.target.closest(".btnLihatStruk");

            if (btnLihatStruk) {
                const id = btnLihatStruk.getAttribute("data-id");

                // Ganti alert menjadi modal kustom jika ingin menghilangkan alert,
                // namun karena permintaan fokus ke desain, kita pertahankan fetch logic.
                // Tambahkan kelas loading sementara
                document.getElementById("riwayatStrukContent").innerHTML = `
                    <p class="text-center text-muted"><i class="fas fa-spinner fa-spin me-2"></i>Memuat data...</p>
                `;

                fetch(`/kasir/transaksi/struk-ajax/${id}`, {
                        headers: {
                            "X-Requested-With": "XMLHttpRequest"
                        }
                    })
                    .then(res => {
                        if (!res.ok) {
                            // Jika respons tidak sukses (misal 404), throw error
                            throw new Error('Gagal mengambil data struk. Status: ' + res.status);
                        }
                        return res.json();
                    })
                    .then(data => {

                        // Menggunakan kelas styling yang baru
                        document.getElementById("riwayatStrukContent").innerHTML = `
                        <p><strong>Kode Transaksi:</strong> <span class="fw-semibold">${data.kode}</span></p>
                        <p><strong>Total:</strong> <span class="text-strong-success">Rp ${data.total}</span></p>
                        <p><strong>Bayar:</strong> <span>Rp ${data.bayar}</span></p>
                        <p style="border-top: 1px solid #ddd; padding-top: 10px;">
                            <strong>Kembalian:</strong> <span class="text-strong-primary">Rp ${data.kembalian}</span>
                        </p>
                        `;

                        document.getElementById("btnCetakRiwayat").href = data.pdf_url;

                        let modal = new bootstrap.Modal(document.getElementById('riwayatStrukModal'));
                        modal.show();
                    })
                    .catch(err => {
                        // Ganti alert dengan pesan di konsol atau tampilkan di modal
                        console.error("Gagal mengambil struk:", err);

                        // Tampilkan pesan error di modal
                        document.getElementById("riwayatStrukContent").innerHTML = `
                            <div class="alert alert-danger" role="alert">
                                Gagal memuat data struk. Silakan coba lagi.
                            </div>
                        `;

                        let modal = new bootstrap.Modal(document.getElementById('riwayatStrukModal'));
                        modal.show();
                    });
            }

        });
    </script>
@endsection
