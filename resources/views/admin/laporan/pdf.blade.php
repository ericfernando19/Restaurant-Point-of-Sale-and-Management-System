<style>
    /* Global Styles for Print */
    body {
        font-family: Arial, sans-serif;
        font-size: 12px;
        color: #333;
    }

    /* Header Section */
    .header {
        text-align: center;
        margin-bottom: 20px;
    }

    .header h1 {
        font-size: 18px;
        color: #008cba;
        /* Warna Aksen */
        margin: 0;
    }

    .header p {
        margin: 2px 0;
        font-size: 11px;
        color: #666;
    }

    /* Date and Separator */
    .date-info {
        text-align: left;
        font-size: 13px;
        font-weight: bold;
        margin-bottom: 15px;
        padding-bottom: 5px;
        border-bottom: 2px solid #ccc;
    }

    /* Summary Card (Optional, for better visual) */
    .summary {
        width: 100%;
        margin-bottom: 20px;
        border-collapse: collapse;
    }

    .summary td {
        padding: 10px;
        border: 1px solid #eee;
        background-color: #f8f8f8;
        font-size: 12px;
        font-weight: bold;
    }

    .summary .label {
        width: 30%;
        color: #666;
        background-color: #eee;
    }

    .summary .value {
        width: 70%;
        color: #008cba;
    }

    .summary .value.total {
        color: #2ecc71;
        /* Warna hijau untuk total pendapatan */
        font-size: 14px;
    }

    /* Table Styles */
    .data-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .data-table thead th {
        background-color: #008cba;
        /* Warna Aksen */
        color: white;
        padding: 10px;
        text-align: left;
        font-size: 12px;
        border: 1px solid #008cba;
    }

    .data-table tbody td {
        padding: 8px 10px;
        border: 1px solid #ddd;
        font-size: 11px;
    }

    .data-table tbody tr:nth-child(even) {
        background-color: #f5f5f5;
        /* Zebra striping */
    }

    .data-table .kode-transaksi {
        font-weight: bold;
    }
</style>

<body>
    {{-- Header Restoran --}}
    <div class="header">
        <h1>LAPORAN TRANSAKSI RESTORAN</h1>
        <p>Jl. Contoh No. 123, Kota Anda | Telepon: (021) 1234567 | Email: admin@restoran.com</p>
    </div>

    <div class="date-info">
        Laporan Periode: {{ $tanggal ?? 'Semua Tanggal' }}
    </div>

    {{-- Ringkasan Data (diasumsikan variabel $totalPendapatan dan $jumlahTransaksi ada di controller) --}}
    @if (isset($totalPendapatan) || isset($jumlahTransaksi))
        <table class="summary">
            <tr>
                <td class="label">TOTAL PENDAPATAN BERSIH</td>
                <td class="value total">
                    {{-- Logika ini hanya akan berfungsi jika Anda melewatkan variabel ini dari controller --}}
                    Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}
                </td>
                <td class="label">JUMLAH TRANSAKSI</td>
                <td class="value">{{ $jumlahTransaksi ?? 0 }} Transaksi</td>
            </tr>
        </table>
    @endif

    {{-- Tabel Detail Transaksi --}}
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 20%;">Kode Transaksi</th>
                <th style="width: 30%; text-align: right;">Total Harga</th>
                <th style="width: 50%;">Tanggal & Waktu</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($transaksi as $t)
                <tr>
                    <td class="kode-transaksi">{{ $t->kode_transaksi }}</td>
                    <td style="text-align: right; color: #333; font-weight: bold;">Rp
                        {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($t->created_at)->format('d F Y, H:i:s') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align: center; color: #999; padding: 20px;">
                        --- Tidak ada data transaksi yang tersedia untuk periode ini ---
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
