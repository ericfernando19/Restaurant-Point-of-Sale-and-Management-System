<style>
    /* ======================================
    CSS GLOBAL & RESET UNTUK STRUK
    ======================================
    */
    body {
        font-family: 'Arial', sans-serif;
        /* Font yang bersih dan mudah dibaca */
        font-size: 11px;
        /* Ukuran font yang umum untuk struk thermal */
        width: 250px;
        /* Lebar umum untuk struk thermal 58mm atau 80mm */
        margin: 0 auto;
        padding: 10px;
        color: #333;
    }

    hr {
        border: none;
        border-top: 1px dashed #aaa;
        /* Garis putus-putus modern */
        margin: 10px 0;
    }

    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }

    .text-left {
        text-align: left;
    }

    .fw-bold {
        font-weight: bold;
    }

    /* ======================================
    HEADER & DETAIL TRANSAKSI
    ======================================
    */
    .header-title {
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 5px;
        color: #000;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 2px;
    }

    .info-row span {
        font-weight: normal;
    }

    /* ======================================
    DETAIL ITEM (TABEL)
    ======================================
    */
    .item-table {
        width: 100%;
        border-collapse: collapse;
        /* Hilangkan batas antar sel */
    }

    .item-table th,
    .item-table td {
        padding: 5px 0;
        vertical-align: top;
    }

    .item-table th {
        font-weight: bold;
        border-bottom: 1px solid #ddd;
        border-top: 1px solid #ddd;
    }

    .item-table tbody td {
        border-top: none;
        /* Hilangkan garis antar item */
    }

    .col-menu {
        width: 50%;
        text-align: left;
    }

    .col-qty {
        width: 10%;
        text-align: center;
    }

    .col-harga {
        width: 20%;
        text-align: right;
    }

    .col-subtotal {
        width: 20%;
        text-align: right;
    }

    /* ======================================
    RINGKASAN PEMBAYARAN
    ======================================
    */
    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 3px 0;
        font-size: 12px;
    }

    .summary-row .label {
        font-weight: bold;
    }

    .summary-row .value {
        font-weight: bold;
    }

    .summary-total {
        font-size: 14px;
        padding: 5px 0;
        border-top: 1px dashed #aaa;
        border-bottom: 1px dashed #aaa;
        margin-top: 10px;
        margin-bottom: 10px;
        color: #008cba;
        /* Warna aksen untuk total */
    }

    /* ======================================
    FOOTER
    ======================================
    */
    .footer-text {
        font-size: 10px;
        margin-top: 15px;
    }
</style>

<div class="text-center">
    <h3 class="header-title">Struk Pembayaran</h3>
</div>

<div class="info-row">
    <span class="fw-bold">Kode Transaksi:</span> <span>{{ $transaksi->kode_transaksi }}</span>
</div>
<div class="info-row">
    <span class="fw-bold">Tanggal:</span> <span>{{ $transaksi->created_at->format('d M Y H:i') }}</span>
</div>

<hr>

<table class="item-table">
    <thead>
        <tr>
            <th class="col-menu">Menu</th>
            <th class="col-qty">Qty</th>
            <th class="col-harga">Harga</th>
            <th class="col-subtotal">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transaksi->details as $d)
            <tr>
                <td class="col-menu">{{ $d->menu->nama }}</td>
                <td class="col-qty">{{ $d->qty }}</td>
                <td class="col-harga">Rp {{ number_format($d->menu->harga) }}</td>
                <td class="col-subtotal">Rp {{ number_format($d->subtotal) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<hr>

<div class="summary-total summary-row">
    <span class="label">TOTAL:</span> <span class="value">Rp {{ number_format($transaksi->total_harga) }}</span>
</div>

<div class="summary-row">
    <span class="label">Bayar Tunai:</span> <span class="value">Rp {{ number_format($transaksi->bayar) }}</span>
</div>

<div class="summary-row">
    <span class="label">Kembalian:</span> <span class="value">Rp {{ number_format($transaksi->kembalian) }}</span>
</div>

<p class="text-center footer-text">
    Terima kasih telah berbelanja! 🙏
</p>
