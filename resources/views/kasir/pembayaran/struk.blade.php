<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Struk Pembayaran</title>

    <style>
        /* ======================================
        CSS GLOBAL & RESET UNTUK STRUK
        ======================================
        */
        body {
            /* Mengurangi lebar untuk simulasi kertas thermal */
            font-family: 'Consolas', monospace;
            /* Font monospace untuk tampilan struk klasik/modern */
            font-size: 11px;
            width: 280px;
            /* Lebar yang lebih umum untuk cetak PDF/thermal */
            margin: 0 auto;
            /* Tengah */
            padding: 15px;
            color: #111;
        }

        h3 {
            margin: 0;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 14px;
        }

        /* Detail Transaksi (Kode & Tanggal) */
        .info {
            margin-top: 15px;
            margin-bottom: 15px;
            line-height: 1.6;
            border-top: 1px dashed #777;
            padding-top: 5px;
        }

        /* Tabel Detail Item */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        /* Header Tabel */
        th {
            text-align: left;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
            padding-top: 3px;
        }

        /* Isi Tabel */
        td {
            padding: 4px 0;
            border-bottom: none;
            /* Menghilangkan garis antar item */
        }

        /* Alignment */
        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }

        .fw-bold {
            font-weight: bold;
        }

        /* Total Section */
        .total-row th {
            border: none;
            padding: 5px 0;
            font-size: 12px;
            font-weight: normal;
            /* Mengubah th menjadi normal agar tidak terlalu tebal */
        }

        /* Garis Pemisah Total Akhir */
        .footer-total {
            border-top: 1px solid #000;
            /* Garis tunggal tebal */
            border-bottom: 1px solid #000;
            /* Garis tunggal tebal */
            margin-top: 12px;
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .footer-message {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
        }
    </style>
</head>

<body>

    <h3 class="fw-bold">Struk Pembayaran</h3>

    <div class="info">
        <div style="display: flex; justify-content: space-between;">
            <strong style="width: 80px;">Kode:</strong>
            <span>{{ $transaksi->kode_transaksi }}</span>
        </div>
        <div style="display: flex; justify-content: space-between;">
            <strong style="width: 80px;">Tanggal:</strong>
            <span>{{ $transaksi->created_at->format('d M Y H:i') }}</span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Menu</th>
                <th class="center">Qty</th>
                <th class="right">Harga</th>
                <th class="right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($details as $d)
                <tr>
                    <td>{{ $d->menu->nama }}</td>
                    <td class="center">{{ $d->qty }}</td>
                    <td class="right">{{ number_format($d->menu->harga) }}</td>
                    <td class="right">{{ number_format($d->subtotal) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="footer-total">
        <tbody>
            <tr>
                <th class="right fw-bold" colspan="3" style="font-size: 13px;">TOTAL:</th>
                <th class="right fw-bold" style="font-size: 13px;">{{ number_format($transaksi->total_harga) }}</th>
            </tr>
        </tbody>
    </table>

    <table>
        <tbody>
            <tr class="total-row">
                <th class="right" colspan="3">Bayar Tunai:</th>
                <th class="right">{{ number_format($transaksi->bayar) }}</th>
            </tr>
            <tr class="total-row">
                <th class="right fw-bold">Kembalian:</th>
                <th class="right" colspan="3"
                    style="border-top: 1px dashed #777; padding-top: 5px; font-size: 12px;">
                    {{ number_format($transaksi->kembalian) }}</th>
            </tr>
        </tbody>
    </table>

    <p class="footer-message">
        Terima kasih atas kunjungan Anda!
    </p>

</body>

</html>
