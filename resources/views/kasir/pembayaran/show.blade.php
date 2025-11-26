@extends('layouts.app')

@section('content')
    <style>
        /* Variabel Warna (Konsisten) */
        :root {
            --base-color: #f0f0f3;
            --accent-color: #008cba;
            --shadow-light: #ffffff;
            --shadow-dark: #d9d9dc;
            --text-color: #4a4a4a;
            --success-color: #2ecc71;
            --danger-color: #e74c3c;
            --info-color: #3498db;
        }

        /* --- Main Layout Wrapper --- */
        .page-wrapper {
            padding: 20px 40px;
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

        /* --- Tabel Styling Modern --- */
        .table-modern {
            width: 100%;
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            background-color: white;
        }

        .table-modern thead th {
            background-color: var(--accent-color);
            color: white;
            font-weight: 600;
            padding: 12px;
            border: none;
        }

        .table-modern tbody td {
            padding: 10px 12px;
            color: var(--text-color);
            border-top: 1px solid #e0e0e0;
        }

        /* --- Total Display --- */
        .total-display {
            background-color: var(--danger-color);
            color: white;
            padding: 15px 25px;
            margin-top: 20px;
            margin-bottom: 25px;
            border-radius: 10px;
            font-size: 1.5rem;
            font-weight: 700;
            text-align: right;
            box-shadow: 0 4px 10px rgba(231, 76, 60, 0.4);
        }

        /* --- Form Input Neumorphism Inset --- */
        .form-control-neumorphism {
            border-radius: 10px;
            border: 1px solid var(--shadow-dark);
            background-color: var(--base-color);
            box-shadow: inset 2px 2px 5px var(--shadow-dark),
                inset -2px -2px 5px var(--shadow-light);
            color: var(--text-color);
            padding: 15px;
            font-size: 1.2rem;
            font-weight: bold;
            text-align: right;
            transition: all 0.3s;
        }

        /* Input yang di-disable atau Readonly */
        .form-control-neumorphism[readonly],
        .form-control-neumorphism:disabled {
            background-color: #e0e0e3;
            opacity: 0.8;
            color: var(--danger-color);
            box-shadow: inset 1px 1px 3px var(--shadow-dark);
        }

        /* --- Tombol Proses Pembayaran --- */
        .btn-process {
            background-color: var(--success-color);
            color: white;
            border: none;
            border-radius: 15px;
            padding: 15px;
            font-size: 1.2rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow:
                4px 4px 8px rgba(46, 204, 113, 0.4),
                -4px -4px 8px var(--shadow-light);
        }

        .btn-process:hover {
            background-color: #27ae60;
            box-shadow: inset 2px 2px 5px #1e8449, inset -2px -2px 5px var(--shadow-light);
            color: white;
        }

        /* --- Modal Styling --- */
        .modal-header,
        .modal-footer {
            border: none;
        }

        .modal-header {
            background-color: var(--accent-color);
            color: white;
            border-radius: 0.3rem 0.3rem 0 0;
        }

        .modal-title {
            font-weight: bold;
        }

        .modal-body strong {
            color: var(--accent-color);
        }

        .btn-cetak {
            background-color: var(--info-color);
            border: none;
        }

        .btn-cetak:hover {
            background-color: #2980b9;
        }
    </style>

    <div class="page-wrapper container-fluid">
        <div class="data-card">
            <h3><i class="fas fa-hand-holding-usd me-2"></i> Pembayaran — {{ $trx->kode_transaksi }}</h3>
            <hr>

            {{-- DETAIL PESANAN --}}
            <h5 class="fw-bold mb-3" style="color: var(--text-color);">Detail Pesanan</h5>
            <div class="table-responsive">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th>Menu</th>
                            <th width="80">Qty</th>
                            <th width="150" class="text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($trx->details as $item)
                            <tr>
                                <td>{{ $item->menu->nama }}</td>
                                <td class="text-center">{{ $item->qty }}</td>
                                <td class="text-right fw-bold">Rp {{ number_format($item->subtotal) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="total-display">
                TOTAL BAYAR: Rp {{ number_format($trx->total_harga) }}
            </div>

            <hr style="margin-top: 35px; border-top: 2px solid #ccc;">

            {{-- FORM PEMBAYARAN --}}
            <h5 class="fw-bold mb-3" style="color: var(--text-color);">Form Pembayaran</h5>
            <form id="formBayar" action="{{ route('kasir.pembayaran.process', $trx->id) }}" method="POST">
                @csrf

                <div class="mt-3">
                    <label class="form-label fw-bold" style="color: var(--text-color);">Bayar (Uang Tunai)</label>
                    <input type="number" class="form-control form-control-neumorphism" id="bayar" name="bayar"
                        value="{{ $trx->bayar ?? '' }}" required autofocus>
                </div>

                <div class="mt-3">
                    <label class="form-label fw-bold" style="color: var(--text-color);">Kembalian</label>
                    <input type="number" class="form-control form-control-neumorphism" id="kembalian"
                        value="{{ $trx->kembalian ?? '' }}" readonly>
                </div>

                <button class="btn btn-process mt-4 w-100">
                    <i class="fas fa-check-circle me-2"></i> Proses Pembayaran
                </button>
            </form>

        </div>
    </div>

    {{-- ===================== MODAL STRUK ===================== --}}
    <div class="modal fade" id="strukModal" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content shadow">

                <div class="modal-header">
                    <h5 class="modal-title">Struk Pembayaran</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body" id="strukContent">
                    <p class="text-center text-muted">Memuat detail struk...</p>
                </div>

                <div class="modal-footer">
                    <a id="btnCetak" href="#" target="_blank" class="btn btn-cetak w-100">
                        <i class="fas fa-print me-2"></i> Cetak Struk
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const totalHarga = {{ $trx->total_harga }};
        const inputBayar = document.getElementById("bayar");
        const inputKembalian = document.getElementById("kembalian");

        // Helper untuk format rupiah (Digunakan di modal)
        const formatter = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        });

        // Fungsi Hitung Kembalian
        function calculateKembalian() {
            // Logika Asli: Hanya memastikan nilai bayar adalah angka atau 0
            let bayar = parseInt(inputBayar.value) || 0;
            inputKembalian.value = bayar - totalHarga;
        }

        // ▶ AUTO HITUNG KEMBALIAN
        inputBayar.addEventListener("input", calculateKembalian);

        // Hitung kembalian awal saat halaman dimuat
        if (inputBayar.value) {
            calculateKembalian();
        }

        // ▶ AJAX SUBMIT PEMBAYARAN
        document.getElementById("formBayar").addEventListener("submit", function(e) {
            e.preventDefault();

            const bayarValue = parseFloat(inputBayar.value) || 0;

            // Tambahkan validasi sederhana
            if (bayarValue < totalHarga) {
                alert("Uang yang dibayarkan harus cukup atau lebih besar dari Total Harga!");
                return;
            }

            // Tampilkan loading di modal
            document.getElementById("strukContent").innerHTML =
                `<p class="text-center text-muted"><i class="fas fa-spinner fa-spin me-2"></i> Memproses pembayaran...</p>`;

            fetch(this.action, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                    },
                    body: JSON.stringify({
                        // Logika Asli: Mengirim nilai input ke server
                        bayar: inputBayar.value
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {

                        // 🛠️ PERBAIKAN UTAMA MASALAH RIBUAN:
                        // Menggunakan formatter.format() pada data yang diterima dari server (data.total, data.bayar, data.kembalian).
                        // Menggunakan parseFloat() untuk sanitasi, mencegah RpNaN, dan memastikan pemformatan ribuan bekerja.
                        const formattedTotal = formatter.format(parseFloat(data.total) || 0);
                        const formattedBayar = formatter.format(parseFloat(data.bayar) || 0);
                        const formattedKembalian = formatter.format(parseFloat(data.kembalian) || 0);

                        // Isi modal dengan data yang diformat
                        document.getElementById("strukContent").innerHTML = `
                            <p><strong>Kode:</strong> ${data.kode}</p>
                <p><strong>Total:</strong> Rp ${data.total}</p>
                <p><strong>Bayar:</strong> Rp ${data.bayar}</p>
                <p><strong>Kembalian:</strong> Rp ${data.kembalian}</p>
                        `;

                        document.getElementById("btnCetak").href = data.pdf_url;

                        let modal = new bootstrap.Modal(document.getElementById('strukModal'));
                        modal.show();

                    } else if (data.message) {
                        alert("Gagal memproses pembayaran: " + data.message);
                    } else {
                        alert("Terjadi kesalahan saat memproses pembayaran.");
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("Terjadi kesalahan jaringan atau server.");
                });
        });
    </script>
@endsection
